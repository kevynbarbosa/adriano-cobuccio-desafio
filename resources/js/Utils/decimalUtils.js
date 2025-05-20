export function decimalLocale(valor) {
    // Converte o valor para número decimal
    const numero = parseFloat(valor);

    // Verifica se o valor é um número válido
    if (isNaN(numero)) {
        return valor; // Retorna o valor original se não for um número
    }

    // Formata o número para o padrão brasileiro
    return numero.toLocaleString("pt-BR", { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}
