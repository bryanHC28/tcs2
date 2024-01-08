<template>

  <div>
  
     <form @submit.prevent="guardarDatos" class="data-form">
      <div class="form-group">
         <input hidden  type="text" id="empresa" v-model="empresa" class="form-control">
         <input hidden type="text" id="sucursal" v-model="sucursal" class="form-control">
      </div>
      
       <div class="form-group">
       <label for="area">Plaza comercial/Sucursal: *</label>
  
    <select v-model="area" @change="updateResponsables();updateniveles()" class="form-control" required>
      <option value="">Seleccione...</option>
      <option value="Cuauhtémoc comercial">Cuauhtémoc comercial</option>
      <option value="Cuauhtémoc residencial">Cuauhtémoc residencial</option>
      <option value="Almanara">Almanara</option>
      <option value="Trebol Park">Trebol Park</option>
    </select>
      </div>
    

      <div class="form-group">
        <label for="nivel">Nivel/Area:</label>
       <select v-model="selectedNivel" class="form-control">
        <option value="">Seleccione...</option>
      <option v-for="nivel in niveles" :value="nivel" :key="nivel">{{ nivel }}</option>
    </select>

      </div>

 
        <div class="form-group">
       <label for="prioridad">Prioridad: *</label>
    <select class="form-control" v-model="prioridad" id="prioridad" required>
      <option value="">Seleccione...</option>
      <option value="Alta">Alta</option>
      <option value="Media">Media</option>
      <option value="Baja">Baja</option>
    </select>
      </div>
        <div class="form-group">
       <label for="tipo_tcs">Tipo ticket: *</label>
    <select class="form-control" v-model="tipo_tcs" id="tipo_tcs" required>
      <option value="">Seleccione...</option>
      <option value="Correctivo">Correctivo</option>
      <option value="Preventivo">Preventivo</option>
      <option value="Mejora continua">Mejora continua</option>
    </select>
      </div>

      <div class="form-group">
       <label for="responsable">Responsable: *</label>
       <select v-model="selectedResponsable" class="form-control" required>
        <option value="">Seleccione...</option>
      <option v-for="responsable in responsables" :value="responsable" :key="responsable">{{ responsable }}</option>
    </select>

      </div>
      <div class="form-group">
        <label for="descripcion">Trabajo a realizar:</label>
        <textarea id="descripcion" v-model="descripcion" class="form-control"></textarea>
      </div>
        <div class="form-group">
        <label for="fecha_estimada">Fecha estimada: *</label>
        <input type="date" id="fecha_estimada" v-model="fecha_estimada" class="form-control" required>
      </div>
       <div class="form-group">
        <label for="fecha_cita">Cita y hora</label>
        <input type="datetime-local" id="fecha_cita" v-model="fecha_cita" class="form-control">
      </div>

      <div class="form-group">  
        <label for="fileInput" class="mb-2">Foto<span class="text-danger">*</span></label>
    <div class="image-upload-container">
        <div class="image-upload-one">
            <div class="center">
                <div class="form-input">
                    <label for="fileInput">
                        <img id="fileInputpreview" src="https://i.pinimg.com/originals/6d/ff/9c/6dff9cc7feaffd490fb215bb7e059312.png">
                        <button type="button" class="imgRemove" @click="removerimagenfileInput"></button>
                    </label>
                   
                    <input type="file" @change=" mostrarprevisualizacionfileInput($event)" class="form-control-file" id="fileInput" name="fileInput">

                
                </div>
                <small class="small"> icon  &#8634;  remove  </small>
            </div>
        </div>

    </div>


    <div>
 
   
</div>
  </div>

      <div class="form-group">
        <button type="button" class="btn btn-success" @click="guardarDatos">Guardar</button>

        <button type="button" class="btn btn-primary" @click="sincronizarDatos" :style="{ backgroundColor: 'green'  }">Sincronizar</button>
        
      


      </div>
  
    </form>

    <h2>Datos almacenados:</h2>
    <button type="button" class="btn btn-danger" @click="borrarDatos"  :style="{ backgroundColor: 'red'  }">Borrar datos</button>
     <table class="data-table">
      <thead>
        <tr>
         <th>Folio #</th>
          <th>Sucursal</th>
          <th>Nivel</th>
          <th>Prioridad</th>
          <th>Tipo ticket</th>
          <th>Fecha estimada</th>
          <th>Fecha cita</th>
          <th>Descripcion</th>
          <th>Responsable</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in storedData" :key="item.id">
          <td># 300{{ item.id }}</td> 
          <td>{{ item.area }}</td>
          <td>{{ item.nivel }}</td>
             <td>{{ item.prioridad }}</td>
          <td>{{ item.tipo_tcs }}</td>
             <td>{{ item.fecha_estimada }}</td>
             <td>{{ item.fecha_cita }}</td>
          <td>{{ item.descripcion }}</td>
          <td>{{ item.responsable }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      empresa: "DemoProyectos9",
      prioridad: '',
      tipo_tcs: '',
      fecha_estimada: '',
      fecha_cita: '',
      descripcion: '',
      storedData: [], // Arreglo para almacenar los datos recuperados de IndexedDB
      area: '', // Valor seleccionado para sucursal
      selectedResponsable: '', // Valor seleccionado para responsable
      responsables: [],
      selectedNivel: '',
      niveles: [],
      sucursal:'',
      syncInterval: null,
      imageData: null,

    };
  },
  created() {
    // Recupera los datos almacenados al cargar el componente
    this.recuperarDatos();
  
  },
 
  beforeDestroy() {
    // Limpiar el temporizador cuando el componente se destruye
    clearInterval(this.syncInterval);
  },
  methods: {


  mostrarprevisualizacionfileInput(event){
if(event.target.files.length > 0){
let src = URL.createObjectURL(event.target.files[0]);
let preview = document.getElementById("fileInputpreview");
preview.src = src;
preview.style.display = "block";
}
},

  removerimagenfileInput() {
document.getElementById("fileInputpreview").src = "https://i.pinimg.com/originals/6d/ff/9c/6dff9cc7feaffd490fb215bb7e059312.png";
document.getElementById("fileInput").value = null;
},
    
  convertToBase64(event) {
    const file = event.target.files[0];
    const reader = new FileReader();

    reader.onload = () => {
      this.imageData = reader.result;
      // 2. Llama a guardarDatos después de que imageData se haya establecido.
      this.guardarDatos();
    };

    if (file) {
      reader.readAsDataURL(file);
    }
  },


  
    guardarDatos() {

 

      const data = {
        
        empresa: this.empresa,
        area: this.area,
        nivel: this.selectedNivel,
        prioridad: this.prioridad,
        tipo_tcs: this.tipo_tcs,
        responsable: this.selectedResponsable,
        fecha_estimada: this.fecha_estimada,
         fecha_cita: this.fecha_cita,
        descripcion: this.descripcion,
        sucursal: this.sucursal,
       
      };

      // Realiza la conversión de la imagen a Base64 dentro de guardarDatos
  const fileInput = document.getElementById('fileInput'); // Debes tener un elemento con el ID 'fileInput' en tu HTML
  const file = fileInput.files[0];




  if (file) {
  const reader = new FileReader();
  reader.onload = () => {
    
    data.imageData = reader.result ?? null; // Almacena la imagen convertida en imageData
    
    const request = indexedDB.open('miBaseDeDatos', 1);

    request.onsuccess = (event) => {
      const db = event.target.result;
      const transaction = db.transaction('almacenDeObjetos', 'readwrite');
      const objectStore = transaction.objectStore('almacenDeObjetos');

      objectStore.add(data);

      this.area = '';
      this.sucursal = '';
      this.selectedNivel = '';
      this.prioridad = '';
      this.tipo_tcs = '';
      this.selectedResponsable = '';
      this.fecha_estimada = '';
      this.fecha_cita = '';
      this.descripcion = '';
      this.sucursal = '';
      fileInput.value='';
      // Después de guardar, recupera los datos actualizados
      this.removerimagenfileInput();
      this.recuperarDatos();
    };
  };
  reader.readAsDataURL(file);
} else {
  const request = indexedDB.open('miBaseDeDatos', 1);

request.onsuccess = (event) => {
  const db = event.target.result;
  const transaction = db.transaction('almacenDeObjetos', 'readwrite');
  const objectStore = transaction.objectStore('almacenDeObjetos');

  objectStore.add(data);

  this.area = '';
  this.sucursal = '';
  this.selectedNivel = '';
  this.prioridad = '';
  this.tipo_tcs = '';
  this.selectedResponsable = '';
  this.fecha_estimada = '';
  this.fecha_cita = '';
  this.descripcion = '';
  this.sucursal = '';
  // Después de guardar, recupera los datos actualizados
  this.recuperarDatos();
};
  }

 

    
    },
     

    recuperarDatos() {


  return new Promise((resolve) => {
    const request = indexedDB.open('miBaseDeDatos', 1);

    request.onsuccess = (event) => {
      const db = event.target.result;
      const transaction = db.transaction('almacenDeObjetos', 'readonly');
      const objectStore = transaction.objectStore('almacenDeObjetos');

      const data = [];
      objectStore.openCursor().onsuccess = (event) => {
        const cursor = event.target.result;
        if (cursor) {
          data.push(cursor.value);
          cursor.continue();
        } else {
          // Asigna los datos recuperados al arreglo de datos
          this.storedData = data;
          resolve(data); // Resuelve la promesa con los datos recuperados
        }
      };
    };
  });
},


    updateResponsables() {
      // Lógica para actualizar las opciones de responsable según la selección de sucursal
      if (this.area === 'Almanara') {
        this.responsables = ['Elias Quiñones','Oscar Saucedo'];
        this.sucursal='Almanara';
      } else if (this.area === 'Trebol Park') {
        this.responsables = ['Reynaldo García','Brenda Oviedo', ' Francisco Leija'];
        this.sucursal='Trebol Park';
      } else if (this.area === 'Cuauhtémoc comercial'  || this.area === 'Cuauhtémoc residencial') {
        this.responsables = ['Jose Castillo', 'Rocio Salazar', 'Cristina Herrera'];
        this.sucursal='Centro Cuauhtémoc';
       
      } else {
        this.responsables = [' '];
   
      }
    },

    updateniveles() {
      // Lógica para actualizar las opciones de responsable según la selección de sucursal
      if (this.area === 'Almanara') {
        this.niveles = ['PASILLOS','ESTACIONAMIENTO','MODULO 1','MODULO 2','MODULO 3','MODULO 4','MODULO 5','MODULO 6']; 
      } else if (this.area === 'Trebol Park') {
        this.niveles = ['VIVIENDA','LOBBY VIVIENDA', 'ESTACIONAMIENTO VIVIENDA','COMERCIO','OFICINAS','ESTACIONAMIENTO COMERCIO OFICINAS']; 
      } else if (this.area === 'Cuauhtémoc comercial' ) {
        this.niveles = ['N1','N2','N3','N4','N5','N6','N7','N8','PB','E1-A','E1-B','E2-A','E2-B','E3-A','E3-B','E4-A','E4-B'];
      } else if (this.area === 'Cuauhtémoc residencial' ) {
        this.niveles = ['P8','P9','P10','P11','P12','P14','P15','P16','Terraza jardín','Gimnasio','Area infantil','Terraza asador Pino Suárez','Planta Baja','E4-A','E4-B'];
      }else {
        this.niveles = [' '];
      
      }
    },



    sincronizarDatos() {
      Loader.show();
      if (this.enviandoDatos) {
    // Ya se están enviando los datos, no hagas nada.
    return;
  }

  this.enviandoDatos = true; // Marca que se están enviando los datos
  this.recuperarDatos();

  axios.post('https://tickets.pruebas.xyz/tickets/public/api/resources/offline', this.storedData)
    .then(response => {
      // Manejar la respuesta de la API
      Loader.hide();
      console.log('Datos sincronizados con éxito:', response.data.contador);
      window.alert("Fuerón sincronizados: "+response.data.contador+" ticket(s)");
      // Opcionalmente, puedes restablecer el estado de envío
      this.enviandoDatos = false;
        // Opcionalmente, puedes eliminar los datos almacenados en IndexedDB después de sincronizarlos
        this.borrarDatos();
    })
    .catch(error => {
      // Manejar errores en la sincronización
      
      console.error('Error al sincronizar datos:', error);
      window.alert("Error al sincronizar datos:"+ error);
      
      Loader.hide();
      // Opcionalmente, puedes restablecer el estado de envío en caso de error
      this.enviandoDatos = false;
    });
  },



  borrarDatos() {
    const request = indexedDB.open('miBaseDeDatos', 1);

    request.onsuccess = (event) => {
      const db = event.target.result;
      const transaction = db.transaction('almacenDeObjetos', 'readwrite');
      const objectStore = transaction.objectStore('almacenDeObjetos');

      // Borra todos los objetos del almacén
      objectStore.clear();

      // Recupera los datos actualizados después de borrar
      this.recuperarDatos();
    };
  },



 





    verificarConexionInternet() {
      return new Promise((resolve) => {
        // Realiza una solicitud HTTP a un recurso en línea
        axios.get('https://pokeapi.co/api/v2/pokemon/ditto').then(() => {
          resolve(true); // Si la solicitud es exitosa, hay conexión a Internet
          console.log("si hay internet");
        }).catch(() => {
          resolve(false); // Si la solicitud falla, no hay conexión a Internet
        });
      });
    },







  },
};
</script>

<style scoped>
/* Estilos para el formulario */
.data-form {
  max-width: 400px;
  margin: 0 auto;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
  background-color: #f9f9f9;
}

.form-group {
  margin-bottom: 10px;
}

.form-label {
  display: block;
  font-weight: bold;
}

.form-control {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 3px;
}

.btn {
  background-color: #007bff;
  color: #fff;
  padding: 10px 20px;
  border: none;
  border-radius: 3px;
  cursor: pointer;
}

.btn-primary {
  background-color: #007bff;
}

/* Estilos para la tabla (se mantienen iguales) */
.data-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

.data-table th,
.data-table td {
  border: 1px solid #ccc;
  padding: 8px;
  text-align: left;
}

.data-table th {
  background-color: #f2f2f2;
  font-weight: bold;
}

/* Estilos para la tabla */
.data-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

.data-table th,
.data-table td {
  border: 1px solid #ccc;
  padding: 8px;
  text-align: left;
}

.data-table th {
  background-color: #f2f2f2;
  font-weight: bold;
}

/* Estilos para hacer la tabla responsiva */
@media (max-width: 768px) {
  .data-table {
    display: block;
    overflow-x: auto;
  }
  
  .data-table th,
  .data-table td {
    white-space: nowrap;
  }
}

.image-upload-one{
    grid-area: img-u-one;
    display: flex;
    }


    .image-upload-container{
    display: grid;
    grid-template-areas: 'img-u-one img-u-two img-u-three img-u-four img-u-five img-u-six';
    }
    .center {
    display:inline;
    margin: 3px;
    }

    .form-input {
    width:100px;
    padding:3px;

    }
    .form-input input {
    display:none;
    }
    .form-input label {
    display:block;
    width:105px;
    height: auto;
    background: gray;
    max-height: 105px;

    cursor:pointer;
    }

    .form-input img {
    width:105px;
    height: 105px;
    }

    .imgRemove{
    position: relative;
    bottom: 105px;
    left: 70%;
    border: none;
    font-size: 25px;
    outline: none;
    }
    .imgRemove::after{
    content: ' \21BA';
    color: black;
    font-weight: 900;
    border-radius: 8px;
    cursor: pointer;
    }

    .small{
    color: black;
    }

    @media only screen and (max-width: 700px){
    .image-upload-container{
    grid-template-areas: 'img-u-one img-u-two img-u-three'
    'img-u-four img-u-five img-u-six';
    }
    }
</style>