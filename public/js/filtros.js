
/** Script encargado la búsqueda de usuarios dinámica mientras el usuario
 * introduce el dni.
 */

window.addEventListener('load',function(){
        /** Cuando el usuario empiece la búsqueda escribiendo el dni,
        devolvemos los resultados */
        document.getElementById("filtro_usuario").addEventListener("change", () => {
            if((document.getElementById("filtro_usuario").value.length)>=1)
                fetch(`/admin/usuarios?texto=${document.getElementById("filtro_usuario").value}`,{ method:'get' })
                .then(response  =>  response.text() )
                .then(html      =>  {   document.getElementById("resultados").innerHTML = html  })
            else
                document.getElementById("resultados").innerHTML = ""
        })
    });
