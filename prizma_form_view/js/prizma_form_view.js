// This code controls the add of extra Sedes Alternas to the form.

var original_sedes_alternas = [2,3]
var sedes_alternas = [2,3]

var original_accionistas = [1,2,3,4,5,6,7,8,9,10]
var accionistas = [1,2,3,4,5,6,7,8,9,10]
var miembros = [1,2,3,4,5,6,7,8,9,10]

var agregarMasSedesButton = document.querySelector('.agregar-mas-sedes');

if (agregarMasSedesButton) {
  agregarMasSedesButton.addEventListener('click', function(e) {
    e.preventDefault();

    if (sedes_alternas !== undefined && sedes_alternas.length > 0) {
      var currentSede = sedes_alternas.shift();
      document.querySelector('.sede-alterna-' + currentSede).style.display = 'block';
    }
  });
}

document.querySelectorAll('.remove-sede-alterna-button').forEach(function(button) {
  button.addEventListener('click', function(e) {
    e.preventDefault();
    var sedeNumber = e.target.getAttribute('data-sede');
    var sedeFields = document.querySelector('.sede-alterna-' + sedeNumber);
    sedeFields.style.display = 'none';
    sedes_alternas.push(sedeNumber);
    sedeFields.querySelectorAll('input, select, textarea').forEach(function(input) {
    input.value = '';
    });
  });
});


var agregarMasAccionistasButton = document.querySelector('.agregar-mas-accionistas');

if (agregarMasAccionistasButton) {
  agregarMasAccionistasButton.addEventListener('click', function(e) {
    e.preventDefault();

    if (accionistas !== undefined && accionistas.length > 0) {
      var currentAccionista = accionistas.shift();
      document.querySelector('.accionista-' + currentAccionista).style.display = 'block';
    }
  });
}

document.querySelectorAll('.remove-accionista-button').forEach(function(button) {
  button.addEventListener('click', function(e) {
    e.preventDefault();
    var accionistaNumber = e.target.getAttribute('data-accionista');
    var accionistaFields = document.querySelector('.accionista-' + accionistaNumber);
    accionistaFields.style.display = 'none';
    accionistas.push(accionistaNumber);
    accionistaFields.querySelectorAll('input, select, textarea').forEach(function(input) {
    input.value = '';
    });
  });
});

var agregarMasMiembrosButton = document.querySelector('.agregar-mas-miembros');

if (agregarMasMiembrosButton) {
  agregarMasMiembrosButton.addEventListener('click', function(e) {
    e.preventDefault();

    if (accionistas !== undefined && miembros.length > 0) {
      var currentMiembro = miembros.shift();
      document.querySelector('.junta_block_' + currentMiembro).style.display = 'block';
    }
  });
}

document.querySelectorAll('.remove-junta-button').forEach(function(button) {
  button.addEventListener('click', function(e) {
    e.preventDefault();
    var miembroNumber = e.target.getAttribute('data-junta');
    console.log(miembroNumber);
    var miembroFields = document.querySelector('.junta_block_' + miembroNumber);
    miembroFields.style.display = 'none';
    miembros.push(miembroNumber);
    miembroFields.querySelectorAll('input, select, textarea').forEach(function(input) {
    input.value = '';
    });
  });
});

document.addEventListener("DOMContentLoaded", function() {
    let elements = document.querySelectorAll('.webform-progress-tracker > li');
    elements.forEach(function(element) {
        let the_text = element.getAttribute("title");
        let span = document.createElement('span');
        span.classList.add('tracker-text-class');
        let capitalizedText = the_text.charAt(0).toUpperCase() + the_text.slice(1).toLowerCase();
        span.textContent = capitalizedText;
        element.appendChild(span);
    });

    // Valida para mostrar las sedes si no estan vacias
    for(let curri=2; curri<=3; curri++){
        let contenedor = document.querySelector('.sede-alterna-' + curri);
        if(contenedor){
            let primerInput = contenedor.querySelector('input');
            if (primerInput && primerInput.value.trim() === '') {
                document.querySelector('.sede-alterna-' + curri).style.display = 'none';
            }
        }
    }

    // validar para accionistas y socios si no estan vacios
    for(let curra=2; curra<=10; curra++){
        let contenedor = document.querySelector('.accionista-' + curra);
        if (contenedor) {
            let primerInput = contenedor.querySelector('input');
            if (primerInput && primerInput.value.trim() === '') {
                document.querySelector('.accionista-' + curra).style.display = 'none';
            }
        }

        let contenedor2 = document.querySelector('.junta_block_' + curra);
        if(contenedor2) {
            let primerInput2 = contenedor2.querySelector('input');
            if (primerInput2 && primerInput2.value.trim() === '') {
                document.querySelector('.junta_block_' + curra).style.display = 'none';
            }
        }
    }

    // Cambiar save draft
    document.querySelector('#edit-draft').value = 'Guardar!'

    let loadingScreen = document.getElementById('loadingScreen');
    if (loadingScreen) {
        loadingScreen.style.display = 'none';
    }
});
