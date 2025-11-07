const botoes = document.querySelectorAll('.add-carrinho');
const carrinhoSidebar = document.getElementById('carrinhoSidebar');
const lista = document.getElementById('itensCarrinho');
const totalSpan = document.getElementById('totalCarrinho');
let carrinho = [];

// === Botão flutuante do carrinho ===
const botaoCarrinho = document.createElement('button');
botaoCarrinho.classList.add('carrinho-flutuante');
botaoCarrinho.innerHTML = '<i class="fa-solid fa-cart-shopping"></i><span class="carrinho-contador">0</span>';
document.body.appendChild(botaoCarrinho);

const contador = botaoCarrinho.querySelector('.carrinho-contador');

// Abrir/fechar o painel lateral
botaoCarrinho.addEventListener('click', () => {
  carrinhoSidebar.classList.toggle('ativo');
});

// Adicionar itens ao carrinho
botoes.forEach(btn => {
  btn.addEventListener('click', () => {
    const nome = btn.getAttribute('data-nome');
    const preco = parseFloat(btn.getAttribute('data-preco'));
    const item = carrinho.find(i => i.nome === nome);
    if (item) item.qtd++;
    else carrinho.push({ nome, preco, qtd: 1 });

    atualizarCarrinho();
    carrinhoSidebar.classList.add('ativo');
  });
});

function atualizarCarrinho() {
  lista.innerHTML = '';
  let total = 0;

  carrinho.forEach((item, index) => {
    total += item.preco * item.qtd;
    const li = document.createElement('li');
    li.innerHTML = `
      ${item.nome} <span>R$ ${(item.preco * item.qtd).toFixed(2)}</span>
      <button onclick="removerItem(${index})">x</button>
    `;
    lista.appendChild(li);
  });

  totalSpan.textContent = total.toFixed(2);
  contador.textContent = carrinho.length;
}

function removerItem(index) {
  carrinho.splice(index, 1);
  atualizarCarrinho();
}

function finalizarCompra() {
  if (carrinho.length === 0) {
    alert('Seu carrinho está vazio!');
    return;
  }
  alert('Compra finalizada com sucesso!');
  carrinho = [];
  atualizarCarrinho();
  carrinhoSidebar.classList.remove('ativo');
}
