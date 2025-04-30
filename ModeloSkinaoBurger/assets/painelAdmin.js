document.getElementById('form-cadastro-produto').addEventListener('submit', function(event) {
    let nome = document.getElementById('nome').value;
    let preco = document.getElementById('preco').value;
    let descricao = document.getElementById('descricao').value;
    let tproduto = document.getElementById('tproduto').value;

    // Verificar se todos os campos obrigatórios estão preenchidos
    if (nome === "" || preco === "" || tproduto === "") {
        alert("Por favor, preencha todos os campos obrigatórios!");
        event.preventDefault();  // Impede o envio do formulário
        return;
    }

    // Verificar se o preço é um número positivo
    if (parseFloat(preco) <= 0) {
        alert("Por favor, insira um preço válido maior que zero!");
        event.preventDefault();  // Impede o envio do formulário
        return;
    }

    // Verificar se o tipo do produto foi selecionado
    if (tproduto === "") {
        alert("Por favor, selecione o tipo do produto!");
        event.preventDefault();  // Impede o envio do formulário
        return;
    }

    // Verificar se a descrição não excede o limite de caracteres (opcional)
    if (descricao.length > 500) {
        alert("A descrição não pode ter mais de 500 caracteres!");
        event.preventDefault();  // Impede o envio do formulário
        return;
    }
});