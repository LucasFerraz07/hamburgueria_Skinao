document.querySelector('.form-finalizar').addEventListener('submit', function(e) {
    let form = e.target;
    let valid = true;
    let mensagem = "";

    if (typeof carrinhoVazio !== "undefined" && carrinhoVazio) {
        e.preventDefault();
        alert("Seu carrinho está vazio. Adicione itens antes de finalizar o pedido.");
        return;
    }

    const camposObrigatorios = ['nome', 'telefone', 'rua', 'numero', 'bairro', 'cidade', 'cep', 'forma_pagamento'];

    camposObrigatorios.forEach(nome => {
        let campo = form.querySelector(`[name="${nome}"]`);
        if (!campo || campo.value.trim() === "") {
            valid = false;
            mensagem += `- O campo "${nome}" é obrigatório.\n`;
        }
    });

    const telefone = form.querySelector('[name="telefone"]').value.trim();
    if (telefone.length < 8) {
        valid = false;
        mensagem += "- Telefone inválido (mínimo 8 números).\n";
    }

    const cep = form.querySelector('[name="cep"]').value.trim();
    if (!/^\d{8}$/.test(cep)) {
        valid = false;
        mensagem += "- CEP inválido (deve conter 8 números).\n";
    }

    const numero = form.querySelector('[name="numero"]').value.trim();
    if (numero.length === 0 || !/^\d+$/.test(numero)) {
        valid = false;
        mensagem += "- Número do endereço inválido.\n";
    }

    if (!valid) {
        e.preventDefault();
        alert("Corrija os seguintes erros:\n" + mensagem);
    }
});
