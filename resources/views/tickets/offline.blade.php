<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        
        /* Estilo del menú lateral */
        .sidenav {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #333;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }

        .sidenav a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 25px;
            color: #818181;
            display: block;
            transition: 0.3s;
        }

        .sidenav a:hover {
            color: #f1f1f1;
        }

        /* Botón para abrir y cerrar el menú */
        .openbtn {
            font-size: 30px;
            cursor: pointer;
            background-color: #333;
            color: white;
            padding: 10px 15px;
            border: none;
            position: fixed;
            z-index: 2;
            top: 0;
            left: 0;
        }

        .openbtn:hover {
            background-color: #333;
        }

        /* Estilo para cerrar el menú */
        .closebtn {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 30px;
            cursor: pointer;
        }

        /* Contenido principal */
        .main {
            transition: margin-left .5s;
            padding: 16px;
        }
		
	

    /* Estilo de los elementos del menú */
    .sidenav button {
      padding: 15px 25px;
      text-decoration: none;
      font-size: 17px;
      color: white;
      display: block;
      background: none;
      border: none;
      cursor: pointer;
      font-family: "Arial", monospace;
    }

   

    /* Estilo del mensaje de estado en línea */
    .estado-en-linea {
      display: inline-block;
      color: white;
      padding: 5px 10px;
      border-radius: 5px;
      font-weight: bold;
    }

    .icono {
      margin-right: 5px;
      font-size: 20px;
    }

    /* Estilo para cuando está desconectado */
    .estado-desconectado {
      background-color: #D32F2F;
    }

    .container {
      text-align: center;
    }
    </style>
</head>
<body>

<div id="mySidenav" class="sidenav">
   
    <form action="{{ route('web.dashboard.inicio') }}" method="GET">
      <button id="miBoton">Inicio</button>
    </form>
    <form action="{{ route('web.dashboard.tickets.index') }}" method="GET">
      <button id="miBoton2">Ver tickets</button>
    </form>
    <form action="{{ route('web.dashboard.tickets.create') }}" method="GET">
      <button id="miBoton3">Generar ticket</button>
    </form>
</div>

<div class="main">
    <span style="font-size:20px;cursor:pointer"  onclick="toggleNav()">&#9776;</span>
    
	
	
	
	
	<div class="container">
    <div class="estado-en-linea" id="edo">
      <span class="icono" id="c"></span>
      <span class="texto" id="t"></span>
    </div>
  </div>
  <br>
  <br>
  <br>
   <div id="app">
    <example-component/>
  </div>
</div>

<script>
var menuOpen = false;

function toggleNav() {
    if (menuOpen) {
        closeNav();
    } else {
        openNav();
    }
    menuOpen = !menuOpen;
}

function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    document.querySelector('.main').style.marginLeft = "250px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.querySelector('.main').style.marginLeft= "0";
}
</script>

</body>
	<script src="{{ asset('js/indexeddb.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/loader.js') }}"></script>
	<script>
  const miBoton = document.getElementById('miBoton');
  const miBoton2 = document.getElementById('miBoton2');
  const miBoton3 = document.getElementById('miBoton3');
  const estado = document.getElementById('edo');
  const c = document.getElementById('c');
  const t = document.getElementById('t');
  var codigoHTML = '&#128994;'; 
  var codigoHTML2 = '🔴'; 
  var online="En línea";
  var offline="Sin internet";
  // Función para comprobar la conexión a Internet
  function verificarConexionInternet() {
    return new Promise((resolve) => {
      // Realiza una solicitud HTTP a un recurso en línea
      axios.get('https://pokeapi.co/api/v2/pokemon/ditto')
        .then(() => {
          resolve(true); // Si la solicitud es exitosa, hay conexión a Internet
        })
        .catch(() => {
          resolve(false); // Si la solicitud falla, no hay conexión a Internet
        });
    });
  }

  // Función para habilitar o deshabilitar el botón según la conexión
  async function actualizarEstadoDelBoton() {
    const tieneConexion = await verificarConexionInternet();
    if (tieneConexion) { 
      console.log("hay conexion");
      miBoton.removeAttribute('disabled');
      miBoton2.removeAttribute('disabled');
      miBoton3.removeAttribute('disabled'); 
      miBoton.style.backgroundColor = '#333';
      miBoton2.style.backgroundColor = '#333';
      miBoton3.style.backgroundColor = '#333';
      estado.style.backgroundColor = '#4CAF50';
      c.innerHTML = codigoHTML;
      t.innerHTML = online;
    } else { 
      console.log("no hay conexion");
      miBoton.setAttribute('disabled', true);
      miBoton2.setAttribute('disabled', true);
      miBoton3.setAttribute('disabled', true);
      miBoton.style.backgroundColor = 'black';
      miBoton2.style.backgroundColor = 'black';
      miBoton3.style.backgroundColor = 'black';
      estado.style.backgroundColor = '#333';
      c.innerHTML = codigoHTML2;
      t.innerHTML = offline;
    }
  }

  actualizarEstadoDelBoton(); // Verificar la conexión al cargar la página

  // Realizar comprobación periódica (opcional) cada 10 segundos
  setInterval(actualizarEstadoDelBoton, 1000);

</script>
</html>
