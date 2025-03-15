document.addEventListener("DOMContentLoaded", function () {
    let reservarBtn = document.getElementById("reservar-btn");
    let cancelarBtn = document.getElementById("cancelar-btn");
    let reservaInfo = document.getElementById("reserva-info");
    let biciIdSpan = document.getElementById("bici-id");
    let contadorTexto = document.getElementById("contador-reserva"); // Elemento para mostrar el contador
    let loadingText = document.getElementById("loading-text"); // Mensaje de "Cancelando reserva..."
    let contadorInterval; // Variable para almacenar el intervalo del contador

    if (reservarBtn) {
        reservarBtn.addEventListener("click", function () {
            console.log("🔄 Reservando bicicleta...");
            reservarBtn.style.display = "none";
            
            fetch("../php/reservar_bici.php", { method: "POST" })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        biciIdSpan.textContent = data.bici_id;
                        reservaInfo.style.display = "block";
                        iniciarContador(15 * 60); // Iniciar contador de 15 minutos
                    } else {
                        alert(data.error);
                        reservarBtn.style.display = "block"; // Mostrar botón si falla
                    }
                })
                .catch(error => {
                    console.error("Error en la petición:", error);
                    reservarBtn.style.display = "block"; // Mostrar botón si hay error
                });
        });
    }

    if (cancelarBtn) {
        cancelarBtn.addEventListener("click", function () {
            cancelarBtn.style.display = "none"; // Ocultar el botón de cancelar antes
            reservaInfo.style.display = "none";  
            loadingText.textContent = "Cancelando reserva...";
            loadingText.style.display = "block"; // Mostrar mensaje de cancelación
        
            fetch("../php/cancelar_reserva.php", { method: "POST" })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        biciIdSpan.textContent = "";
                        detenerContador(); // Detener contador al cancelar

                        // Esperar 2 segundos antes de mostrar el botón de reservar
                        setTimeout(() => {
                            loadingText.style.display = "none"; // Ocultar mensaje
                            loadingText.textContent = ""; // Limpiar el mensaje
                            reservarBtn.style.display = "block"; // Mostrar botón de reservar
                        }, 2000);
                    } else {
                        alert(data.error);
                        cancelarBtn.style.display = "block"; // Volver a mostrar el botón si hay error
                    }
                })
                .catch(error => {
                    console.error("Error en la petición:", error);
                    cancelarBtn.style.display = "block"; // Volver a mostrar el botón si hay error
                });
        });
    }

    document.getElementById("menu-toggle").addEventListener("click", function () {
        document.getElementById("sidebar").style.left = "0";
    });

    document.getElementById("close-sidebar").addEventListener("click", function () {
        document.getElementById("sidebar").style.left = "-250px";
    });

    function iniciarContador(segundos) {
        detenerContador(); // Asegurar que no haya otro contador corriendo
        contadorTexto.style.display = "block"; // Hacer visible el contador
        
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
