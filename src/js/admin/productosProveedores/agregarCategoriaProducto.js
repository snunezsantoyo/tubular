import { guardarCambioBD, mostrarAlerta, mostrarFormulario } from "../../helpers";

(function () {
    const btnAgregar = document.querySelector('#categoria-producto');

    if (btnAgregar) {
        btnAgregar.addEventListener('click', () => {
            const modal = mostrarFormulario('Categoria', 'Agregar Categoria', '',)
            const body = document.querySelector('body');


            modal.addEventListener('click', function (e) {
                e.preventDefault();


                //--------------Aplicando delegation para determinar cuando se dió click en cerrar
                if (e.target.classList.contains('cerrar-modal')) {

                    body.classList.remove('pausar');
                    const formulario = document.querySelector('.formulario-animar');
                    formulario.classList.add('cerrar');


                    setTimeout(() => {
                        modal.remove();
                    }, 500);
                }


                //--------------Aplicando delegation para determinar cuando se dió click en el input de tipo submit
                if (e.target.classList.contains('submit-nuevo-valor')) {

                    body.classList.remove('pausar');

                    const valor = document.querySelector('#valor').value.trim();

                    if (valor === '') {
                        //Mostrar alerta de error
                        mostrarAlerta('El Valor es obligatorio', 'alerta--error',
                            document.querySelector('.formulario-animar legend'));
                        return;
                    }

                    prepararDatos(valor);
                }

            });

            document.querySelector('.dashboard').appendChild(modal);

        });

        async function prepararDatos(valor) {
            const url = '/api/producto-proveedor/agregar/categoria';
            const datos = new FormData();
            datos.append('nombre', valor);
            await guardarCambioBD(datos, url);

        }

    }
})();