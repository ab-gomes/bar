function obterLocalizacao() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(sucesso, erro);
    } else {
        alert("Geolocalização não suportada pelo seu navegador.");
    }
}

function sucesso(posicao) {
    const lat = posicao.coords.latitude;
    const lon = posicao.coords.longitude;

    // API do OpenCage Geocoding para converter latitude/longitude em endereço
    const apiKey = '837a729235d4497294cc3f9e309d68d7'; 
    const url = `https://api.opencagedata.com/geocode/v1/json?q=${lat}+${lon}&key=${apiKey}&language=pt-BR`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            const endereco = data.results[0].formatted;
            document.getElementById('campoLocalizacao').value = endereco;
            document.getElementById('formLocalizacao').submit(); // envia o formulário automaticamente
        })
        .catch(() => {
            alert("Não foi possível obter sua localização. Tente digitar manualmente.");
        });
}

function erro() {
    alert("Permissão negada ou erro ao capturar a localização.");
}


document.addEventListener('DOMContentLoaded', () => {
    // Inicializa o primeiro carrossel (Promoções)
    $('.promocoes-carousel').slick({
        infinite: true,     // Rola infinitamente
        slidesToShow: 1,    // Mostra 1 slide por vez
        slidesToScroll: 1,  // Rola 1 slide por vez
        autoplay: true,     // Ativa o auto-play
        autoplaySpeed: 2500, // Troca a cada 2.5 segundos
        dots: true,         // Mostra os indicadores de bolinha
        arrows: true        // Mostra as setas de navegação
    });

    // Inicializa o segundo carrossel (Serviços)
    $('.servicos-carousel').slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 3000, // Troca a cada 3 segundos (exemplo de configuração diferente)
        dots: true,
        arrows: true
    });

    // Se você tiver outras funcionalidades JavaScript para o site, adicione-as aqui.
    // Ex: lógica para formulários, efeitos de scroll, etc.
});