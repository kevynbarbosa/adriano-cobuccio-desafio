function iniciaisNome(nome = "") {
    var nomes = nome.trim().split(" ");

    if (nomes.length == 0) return "--";

    if (nomes.length == 1) return nomes[0].substring(0, 2).toUpperCase();

    var primeira_inicial = nomes[0].substring(0, 1).toUpperCase();
    var ultima_inicial = nomes[nomes.length - 1].substring(0, 1).toUpperCase();

    return primeira_inicial + ultima_inicial;
}

function formataCpfCnpj(value) {
    if (!value) return null;
    // Remove todos os caracteres que não sejam números
    const cleanValue = value.replace(/\D/g, "");

    // Formata como CPF se o valor tiver 11 dígitos
    if (cleanValue.length === 11) {
        return cleanValue.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
    }

    // Formata como CNPJ se o valor tiver 14 dígitos
    if (cleanValue.length === 14) {
        return cleanValue.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, "$1.$2.$3/$4-$5");
    }

    // Retorna o valor original se não for nem CPF nem CNPJ
    return value;
}

export { formataCpfCnpj, iniciaisNome };
