document.addEventListener("DOMContentLoaded", () => {

  // ===== ELEMENTOS =====
  const pontosEl = document.getElementById("pontos");
  const aulasEl = document.getElementById("aulas");
  const barra = document.getElementById("progresso-preenchido");
  const nivelEl = document.getElementById("nivel");
  const pontosUsuario = document.getElementById("pontosUsuario");

  const listaDesafios = document.getElementById("listaDesafios");
  const btnTodos = document.getElementById("btnTodos");
  const btnMeus = document.getElementById("btnMeus");
  const btnResgatar = document.getElementById("btnResgatar");

  // ===== RANKING ELEMENTOS =====
  const rankingSection = document.querySelector("#ranking ol");

  // ===== DADOS DO USUÁRIO =====
  let usuario = JSON.parse(localStorage.getItem("usuarioAcademia")) || {
    nome: "Maria Eduarda",
    pontos: 0,
    aulas: 0,
    desafios: []
  };

  // ===== DESAFIOS DISPONÍVEIS =====
  const desafiosDisponiveis = [
    { id: 1, nome: "Treinar 5 dias na semana", pontos: 20 },
    { id: 2, nome: "Concluir aula de musculação", pontos: 10 },
    { id: 3, nome: "Participar de um desafio coletivo", pontos: 30 },
    { id: 4, nome: "Postar treino nas redes sociais", pontos: 15 },
    { id: 5, nome: "Fazer avaliação física", pontos: 25 }
  ];

  // ===== ATUALIZA INTERFACE =====
  function atualizarTudo() {
    // Atualiza progresso
    pontosEl.textContent = usuario.pontos;
    aulasEl.textContent = usuario.aulas;
    pontosUsuario.textContent = usuario.pontos;

    // Atualiza barra de progresso
    const porcentagem = Math.min((usuario.pontos / 100) * 100, 100);
    barra.style.width = `${porcentagem}%`;

    // Define nível
    let nivel = "Iniciante";
    if (usuario.pontos >= 30 && usuario.pontos < 60) nivel = "Intermediário";
    else if (usuario.pontos >= 60 && usuario.pontos < 90) nivel = "Avançado";
    else if (usuario.pontos >= 90) nivel = "Atleta";
    nivelEl.textContent = `Nível: ${nivel}`;

    // Atualiza ranking
    atualizarRanking();

    // Salvar no localStorage
    localStorage.setItem("usuarioAcademia", JSON.stringify(usuario));
  }

  // ===== ATUALIZA RANKING =====
  function atualizarRanking() {
    // Ranking fixo de exemplo
    const rankingFixo = [
      { nome: "Marcos", pontos: 76 },
      { nome: "Maria Eduarda", pontos: usuario.pontos },
      { nome: "Rafael Souza", pontos: 59 }
    ];

    // Ordena por pontuação
    rankingFixo.sort((a, b) => b.pontos - a.pontos);

    // Renderiza
    rankingSection.innerHTML = "";
    rankingFixo.forEach(pessoa => {
      const li = document.createElement("li");
      li.innerHTML = `
        <article>
          <img src="FOTOS/${pessoa.nome === "Maria Eduarda" ? "1" : pessoa.nome === "Marcos" ? "2" : "3"}.png" width="100">
          <h4>${pessoa.nome}</h4>
          <p>${pessoa.pontos} Pontos</p>
        </article>
      `;
      rankingSection.appendChild(li);
    });
  }

  // ===== MOSTRAR DESAFIOS =====
  function mostrarTodosDesafios() {
    listaDesafios.innerHTML = "";
    desafiosDisponiveis.forEach(desafio => {
      const jaAdicionado = usuario.desafios.find(d => d.id === desafio.id);
      const btnTexto = jaAdicionado ? "✅ Adicionado" : "➕ Adicionar";

      const card = document.createElement("div");
      card.className = "card p-3 text-center";
      card.innerHTML = `
        <h5>${desafio.nome}</h5>
        <p>Pontos: ${desafio.pontos}</p>
        <button class="btn btn-${jaAdicionado ? "secondary" : "success"}" 
                ${jaAdicionado ? "disabled" : ""} 
                data-id="${desafio.id}">
          ${btnTexto}
        </button>
      `;
      listaDesafios.appendChild(card);
    });

    listaDesafios.querySelectorAll("button").forEach(btn => {
      btn.addEventListener("click", e => {
        const id = parseInt(e.target.dataset.id);
        const desafio = desafiosDisponiveis.find(d => d.id === id);
        usuario.desafios.push({ ...desafio, status: "pendente" });
        atualizarTudo();
        mostrarTodosDesafios();
      });
    });
  }

  // ===== MEUS DESAFIOS =====
  function mostrarMeusDesafios() {
    listaDesafios.innerHTML = "";
    if (usuario.desafios.length === 0) {
      listaDesafios.innerHTML = "<p>Você ainda não adicionou nenhum desafio.</p>";
      return;
    }

    usuario.desafios.forEach(desafio => {
      const card = document.createElement("div");
      card.className = "card p-3 text-center";
      card.innerHTML = `
        <h5>${desafio.nome}</h5>
        <p>Status: <strong>${desafio.status}</strong></p>
        ${
          desafio.status === "pendente"
            ? `<button class="btn btn-success" data-id="${desafio.id}">Concluir</button>`
            : `<button class="btn btn-outline-secondary" disabled>Concluído</button>`
        }
      `;
      listaDesafios.appendChild(card);
    });

    // Botão concluir desafio
    listaDesafios.querySelectorAll(".btn-success").forEach(btn => {
      btn.addEventListener("click", e => {
        const id = parseInt(e.target.dataset.id);
        const desafio = usuario.desafios.find(d => d.id === id);
        desafio.status = "concluído";
        usuario.pontos += desafio.pontos;
        usuario.aulas += 1;
        atualizarTudo();
        mostrarMeusDesafios();
      });
    });
  }

  // ===== EVENTOS =====
  btnTodos.addEventListener("click", mostrarTodosDesafios);
  btnMeus.addEventListener("click", mostrarMeusDesafios);
  btnResgatar.addEventListener("click", () => {
    window.location.href = "loja.html"; // alterar para link real da loja
  });

  // ===== INICIALIZA =====
  mostrarTodosDesafios();
  atualizarTudo();
});
