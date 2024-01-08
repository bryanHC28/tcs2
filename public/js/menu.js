

element = document.getElementById('desc');
element.style.display = 'none';

observaciones = document.getElementById('obs');
observaciones.style.display = 'none';

Costo_estimado = document.getElementById('Costo estimado');
Costo_estimado.style.display = 'none';

Costo_estimado = document.getElementById('ejecucion');
Costo_estimado.style.display = 'none';


function myFunction(key) {

    switch (key) {

        case 1:

        var x = document.getElementById("desc");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }

        break;


        case 2:


        var x = document.getElementById("obs");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }

        break;

        case 3:
        var x = document.getElementById("Costo estimado");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        break;


        case 4:
        var x = document.getElementById("ejecucion");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        break;


        default:
            break;
    }



}
