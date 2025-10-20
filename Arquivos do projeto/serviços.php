<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}
$nomeUsuario = $_SESSION['nome'];
$usuarioId = $_SESSION['id'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>GlitchNet HelpDesk</title>
<link rel="stylesheet" href="styleuser.css">
<style>
/* Estilo neon hacker (igual anterior) */
@import url('https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap');
body { margin:0; font-family:'Share Tech Mono', monospace; background:#111; color:#00ffff; overflow:hidden; }
header { display:flex; justify-content:space-between; align-items:center; border-bottom:2px solid #0099ff; padding:0 20px; height:50px; background:#111; }
.glow { color:#0099ff; text-shadow:0 0 5px #0099ff,0 0 10px #0099ff,0 0 20px #0099ff; }
.user-area { display:flex; align-items:center; gap:20px; font-size:large; }
.profile-image { width:40px; height:40px; border-radius:100px; }
.mainpage { display:flex; height:calc(100vh - 50px); }
.side-main { flex:0 0 220px; background:#000; padding:20px; border-right:1px solid #0099ff; box-shadow: inset -5px 0 10px #00ffff44; overflow-y:auto; }
.side-main ul { list-style:none; padding:0; margin:0; }
.side-main li { margin-bottom:18px; }
.side-main li a { text-decoration:none; color:#0099ff; padding:10px 15px; display:block; font-size:16px; border-radius:4px; transition:0.3s; cursor:pointer; }
.side-main li a:hover { background-color:#0099ff22; }
.col-right { flex:1; background:#111; padding:20px; display:flex; flex-direction:column; gap:12px; overflow-y:auto; }
.panel { border:1px solid #0099ff22; padding:12px; border-radius:6px; background:#111; box-shadow:0 0 15px #0099ff33; }
textarea,input[type=file] { background:transparent; border:1px dashed #0099ff33; color:#00ffff; padding:10px; border-radius:6px; resize:vertical; width:100%; }
textarea { min-height:120px; font-size:14px; }
button { background:transparent; border:1px solid #00ffff; color:#00ffff; padding:10px 12px; border-radius:6px; cursor:pointer; margin-top:6px; transition:all 0.3s ease; }
button:hover { background-color:#0099ff11; box-shadow:0 0 10px #00ffff; }
.term { font-size:13px; color:#00ffff; margin-bottom:8px; text-shadow:0 0 5px #00ffff; }
.lista { display:flex; flex-direction:column; gap:12px; }
.card { background:#111; border-left:3px solid #0099ff; padding:12px; border-radius:6px; box-shadow:0 0 10px #0099ff33; word-break:break-word; }
.card img { max-width:100%; border-radius:6px; margin-top:8px; border:1px solid #0099ff22; filter: drop-shadow(0 0 5px #0099ff) drop-shadow(0 0 10px #0099ff); }
::-webkit-scrollbar { width:8px; }
::-webkit-scrollbar-thumb { background-color:#0099ff33; border-radius:4px; }
</style>
</head>
<body>

<header class="glow">
  <div class="titulo"><h2>GlitchNet - HelpDesk</h2></div>
  <div class="user-area">
    <p><?php echo htmlspecialchars($nomeUsuario); ?> |</p>
    <img src="images/profile.jpg" alt="profile" class="profile-image">
  </div>
</header>

<div class="mainpage">
  <section class="side-main">
    <ul>
      <li><a href="index.php"> Home</a></li>
      <li><a href="#"> Abrir Chat</a></li>
      <li><a href="#"> Minhas Reclamações</a></li>
      <li><a href="logout_animacao.php"> Sair</a></li>
    </ul>
  </section>

  <div class="col-right">
    <div class="panel">
      <div class="term">➤ Enviar Reclamação</div>
      <form id="formReclamacao" enctype="multipart/form-data">
        <textarea name="descricao" placeholder="Descreva o problema"></textarea>
        <input type="file" name="imagem">
        <button type="submit">Enviar</button>
      </form>
    </div>

    <div class="lista" id="lista">
      <p>Carregando...</p>
    </div>
  </div>
</div>

<script type="module">
import { createClient } from "https://cdn.jsdelivr.net/npm/@supabase/supabase-js/+esm";
const SUPABASE_URL = "https://huyibmcljsmridkmlafk.supabase.co";
const SUPABASE_ANON_KEY = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Imh1eWlibWNsanNtcmlka21sYWZrIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTc4ODMxODgsImV4cCI6MjA3MzQ1OTE4OH0.ixBRF60Wlc8xuIvGsizXuiVUpzr4it2UkPAGm4YHRpo";
const supabase = createClient(SUPABASE_URL, SUPABASE_ANON_KEY);

async function carregar(){
  const { data: reclamacoes, error: err1 } = await supabase.from('reclamacoes').select('*').order('id',{ascending:false});
  const lista = document.getElementById('lista');
  lista.innerHTML='';
  if(err1){ lista.innerHTML='<p>Erro: '+err1.message+'</p>'; return; }
  if(!reclamacoes || reclamacoes.length===0){ lista.innerHTML='<p>Nenhuma reclamação ainda.</p>'; return; }

  // Buscar nomes dos usuários
  const userIds = reclamacoes.map(r=>r.usuario_id).filter(Boolean);
  const { data: users } = await supabase.from('usuarios').select('id,nome').in('id',userIds);
  const userMap = {};
  users?.forEach(u=>{ userMap[u.id]=u.nome; });

  reclamacoes.forEach(d=>{
    const div = document.createElement('div');
    div.className='card';
    const nome = d.usuario_id ? userMap[d.usuario_id] : 'Anônimo';
    div.innerHTML=`<time>${nome} | ${d.criado_em||''}</time>
                   <p>${d.descricao||''}</p>
                   ${d.imagem_url?'<img src="'+d.imagem_url+'"/>':''}`;
    lista.appendChild(div);
  });
}
carregar();

document.getElementById('formReclamacao').addEventListener('submit',async e=>{
  e.preventDefault();
  const fd = new FormData(e.target);
  fd.append('usuario_id', '<?php echo $usuarioId; ?>');
  const res = await fetch('chat.php',{method:'POST',body:fd});
  const json = await res.json();
  alert(json.message);
  if(json.ok){ e.target.reset(); carregar(); }
});
</script>

</body>
</html>
