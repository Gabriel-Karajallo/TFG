document.addEventListener("DOMContentLoaded", function () {
    let reservarBtn = document.getElementById("reservar-btn");
    let cancelarBtn = document.getElementById("cancelar-btn");
    let reservaInfo = document.getElementById("reserva-info");
    let biciIdSpan = document.getElementById("bici-id");
    let contadorTexto = document.getElementById("contador-reserva"); 
    let loadingIcon = document.getElementById("loading-icon"); 
    let loadingText = document.getElementById("loading-text"); 
    let contadorInterval; 

    // Recuperar datos de la reserva almacenada al recargar la página
    let reservaActiva = localStorage.getItem("reserva_activa");
    let tiempoExpiracion = localStorage.getItem("reserva_expiracion");

    if (reservaActiva && tiempoExpiracion) {
        let tiempoRestante = Math.floor((parseInt(tiempoExpiracion) - Date.now()) / 1000);
        if (tiempoRestante > 0) {
            biciIdSpan.textContent = reservaActiva;
            reservaInfo.style.display = "block";
            cancelarBtn.style.display = "block"; // Mostrar botón de cancelar
            iniciarContador(tiempoRestante);
        } else {
            localStorage.removeItem("reserva_activa");
            localStorage.removeItem("reserva_expiracion");
        }
    }

    if (reservarBtn) {
        reservarBtn.addEventListener("click", function () {
            console.log("🔄 Reservando bicicleta...");
            reservarBtn.style.display = "none";
            loadingIcon.style.display = "inline-block"; // Mostrar icono de carga

            fetch("../php/reservar_bici.php", { method: "POST" })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        let tiempoActual = Date.now();
                        let tiempoExpira = tiempoActual + 15 * 60 * 1000; // 15 minutos en milisegundos

                        localStorage.setItem("reserva_activa", data.bici_id);
                        localStorage.setItem("reserva_expiracion", tiempoExpira);

                        setTimeout(() => {
                            loadingIcon.style.display = "none"; // Ocultar icono de carga
                            biciIdSpan.textContent = data.bici_id;
                            reservaInfo.style.display = "block";
                            cancelarBtn.style.display = "block"; // Mostrar botón de cancelar
                            iniciarContador(15 * 60);
                        }, 2000); // Retraso de 2 segundos antes de mostrar la reserva
                    } else {
                        alert(data.error);
                        loadingIcon.style.display = "none"; 
                        reservarBtn.style.display = "block";
                    }
                })
                .catch(error => {
                    console.error("Error en la petición:", error);
                    loadingIcon.style.display = "none"; 
                    reservarBtn.style.display = "block";
                });
        });
    }

    if (cancelarBtn) {
        cancelarBtn.addEventListener("click", function () {
            cancelarBtn.style.display = "none";
            reservaInfo.style.display = "none";  
            loadingIcon.style.display = "inline-block"; // Mostrar icono de carga
            loadingText.textContent = "Cancelando reserva...";
            loadingText.style.display = "block";

            fetch("../php/cancelar_reserva.php", { method: "POST" })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        localStorage.removeItem("reserva_activa");
                        localStorage.removeItem("reserva_expiracion");
                        biciIdSpan.textContent = "";
                        detenerContador();

                        setTimeout(() => {
                            loadingIcon.style.display = "none"; // Ocultar icono de carga
                            loadingText.style.display = "none"; 
                            loadingText.textContent = "";
                            reservarBtn.style.display = "block"; 
                        }, 2000); // Retraso de 2 segundos antes de mostrar el botón de reservar
                    } else {
                        alert(data.error);
                        cancelarBtn.style.display = "block"; 
                        loadingIcon.style.display = "none"; 
                    }
                })
                .catch(error => {
                    console.error("Error en la petición:", error);
                    cancelarBtn.style.display = "block"; 
                    loadingIcon.style.display = "none"; 
                });
        });
    }

    function iniciarContador(segundos) {
        detenerContador();
        contadorTexto.style.display = "block";
        actualizarContador(segundos);

        contadorInterval = setInterval(() => {
            segundos--;
            actualizarContador(segundos);
            
            if (segundos <= 0) {
                clearInterval(contadorInterval);
                alert("⏳ Tiempo agotado. La reserva ha sido cancelada automáticamente.");
                cancelarReservaAutomatica();
            }
        }, 1000);
    }

    function actualizarContador(segundos) {
        let minutos = Math.floor(segundos / 60);
        let segundosRestantes = segundos % 60;
        contadorTexto.textContent = `Tiempo restante: ${minutos}:${segundosRestantes < 10 ? '0' : ''}${segundosRestantes}`;
    }

    function detenerContador() {
        clearInterval(contadorInterval);
        contadorTexto.textContent = "";
    }

    function cancelarReservaAutomatica() {
        fetch("../php/cancelar_reserva.php", { method: "POST" })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    localStorage.removeItem("reserva_activa");
                    localStorage.removeItem("reserva_expiracion");
                    biciIdSpan.textContent = "";
                    reservaInfo.style.display = "none";
                    reservarBtn.style.display = "block";
                    detenerContador();
                } else {
                    alert("Error al cancelar la reserva automáticamente.");
                }
            })
            .catch(error => console.error("Error en la cancelación automática:", error));
    }
});

document.getElementById("menu-toggle").addEventListener("click", function () {
    document.getElementById("sidebar").style.left = "0";
});

document.getElementById("close-sidebar").addEventListener("click", function () {
    document.getElementById("sidebar").style.left = "-250px";
});