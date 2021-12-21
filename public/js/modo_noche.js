/** Script encargado de activar el modo noche a través del botón switch
*/

/* Cuando se pulsa el boton de modo noche activamos
o desactivamos el modo noche y lo guardamos en localStorage */
const btnSwitch = document.querySelector('#switch');

btnSwitch.addEventListener('click', () => {
  document.body.classList.toggle('dark');
  btnSwitch.classList.toggle('active');

  if(document.body.classList.contains('dark')){
    localStorage.setItem('dark-mode', 'true');
  } else{
    localStorage.setItem('dark-mode', 'false');
  }
});

// Obtenemos el modo a traves de localstorage

if(localStorage.getItem('dark-mode') == 'true'){
    document.body.classList.add('dark');
    btnSwitch.classList.add('active');
} else {
    document.body.classList.remove('dark');
    btnSwitch.classList.remove('active');
}
