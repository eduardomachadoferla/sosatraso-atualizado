<section id="desenvolvido-por" class="desenvolvido-por">
  <h2>Desenvolvido por</h2>
  <div class="dev-container">
    <div class="dev-card" data-delay="0">
      <div class="dev-img">
        <img src="img/images.jpg" alt="Foto Eduardo">
        <div class="overlay">
          <p>Desenvolvedor Full Stack, responsável pelo front-end e back-end.</p>
        </div>
      </div>
      <h3>Eduardo Ferla</h3>
    </div>

    <div class="dev-card" data-delay="200">
      <div class="dev-img">
        <img src="imagens/ana.jpg" alt="Foto Ana">
        <div class="overlay">
          <p>Designer e responsável pela identidade visual e UX/UI do projeto.</p>
        </div>
      </div>
      <h3>Ana Silva</h3>
    </div>

    <div class="dev-card" data-delay="400">
      <div class="dev-img">
        <img src="imagens/maria.jpg" alt="Foto Maria">
        <div class="overlay">
          <p>Back-end e integração de APIs.</p>
        </div>
      </div>
      <h3>Maria Souza</h3>
    </div>
  </div>
  <canvas id="lineCanvas"></canvas>
</section>

<style>
    /* Tema escuro e geral */
/* Tema preto puro */
body {
  background-color: #000000;
  color: #fff;
  font-family: 'Arial', sans-serif;
  margin: 0;
}

.desenvolvido-por {
  padding: 50px 20px;
  text-align: center;
  background-color: #000000;
  position: relative;
}

.desenvolvido-por h2 {
  font-size: 2.5em;
  margin-bottom: 50px;
  color: #fff;
}

.dev-container {
  display: flex;
  justify-content: center;
  gap: 60px;
  flex-wrap: wrap;
  position: relative;
}

.dev-card {
  background-color: #1a1a1a;
  border-radius: 15px;
  overflow: hidden;
  width: 180px;
  text-align: center;
  opacity: 0;
  transform: translateY(50px);
  transition: all 0.6s ease;
}

.dev-card.visible {
  opacity: 1;
  transform: translateY(0);
}

.dev-img {
  position: relative;
  margin-top: 20px;
}

.dev-img img {
  width: 120px;
  height: 120px;
  border-radius: 50%; /* círculo */
  border: 3px solid #fff;
  object-fit: cover;
}

.overlay {
  position: absolute;
  bottom: 0;
  background: rgba(0,0,0,0.9);
  color: #fff;
  width: 100%;
  transform: translateY(100%);
  transition: transform 0.3s;
  padding: 10px;
  box-sizing: border-box;
  font-size: 0.8em;
}

.dev-card:hover .overlay {
  transform: translateY(0);
}

.dev-card h3 {
  margin: 15px 0;
  font-size: 1.1em;
  color: #fff;
}

#lineCanvas {
  position: absolute;
  top: 0;
  left: 0;
  pointer-events: none;
}
</style>
<script>
    // Efeito fade-in ao scroll
const cards = document.querySelectorAll('.dev-card');

const observer = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    if(entry.isIntersecting) {
      setTimeout(() => {
        entry.target.classList.add('visible');
      }, entry.target.dataset.delay);
    }
  });
}, { threshold: 0.2 });

cards.forEach(card => observer.observe(card));

// Desenhar linhas entre os círculos
const canvas = document.getElementById('lineCanvas');
const ctx = canvas.getContext('2d');

function resizeCanvas() {
  canvas.width = document.querySelector('.dev-container').offsetWidth;
  canvas.height = 250; // altura suficiente para as linhas
  drawLines();
}

function drawLines() {
  ctx.clearRect(0,0,canvas.width,canvas.height);
  const positions = [...cards].map(card => {
    const rect = card.querySelector('img').getBoundingClientRect();
    const containerRect = document.querySelector('.dev-container').getBoundingClientRect();
    return {
      x: rect.left - containerRect.left + rect.width/2,
      y: rect.top - containerRect.top + rect.height/2
    }
  });

  ctx.strokeStyle = '#ffffff';
  ctx.lineWidth = 2;
  for(let i = 0; i < positions.length - 1; i++){
    ctx.beginPath();
    ctx.moveTo(positions[i].x, positions[i].y);
    ctx.lineTo(positions[i+1].x, positions[i+1].y);
    ctx.stroke();
  }
}

window.addEventListener('resize', resizeCanvas);
window.addEventListener('load', resizeCanvas);
window.addEventListener('scroll', drawLines);

</script>
