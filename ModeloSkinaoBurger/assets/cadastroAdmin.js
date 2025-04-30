document.getElementById('form-cadastro').addEventListener('submit', function(event) {
    let email = document.getElementById('email').value;
    let nome = document.getElementById('nome').value;
    let senha = document.getElementById('senha').value;
    let csenha = document.getElementById('csenha').value;

    // Verificar se as senhas são iguais
    if (senha !== csenha) {
        alert("As senhas não coincidem!");
        event.preventDefault();  // Impede o envio do formulário
        return;
    }

    // Verificar se o email e nome não estão vazios
    if (email === "" || nome === "") {
        alert("Por favor, preencha todos os campos!");
        event.preventDefault();  // Impede o envio do formulário
        return;
    }

    // Validar o formato do email
    let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!emailPattern.test(email)) {
        alert("Por favor, insira um email válido!");
        event.preventDefault();  // Impede o envio do formulário
        return;
    }

    // Validar a senha
    if (senha.length < 8 || senha.length > 25) {
        alert("A senha deve ter entre 8 e 25 caracteres!");
        event.preventDefault();  // Impede o envio do formulário
        return;
    }
});