<?php include_once __DIR__ . '/../../templates/header-dashboard.php'; ?>
<div class="contenedor">
    <div class="flex-izquierda">
        <a class="btn-regresar" href="/admin/producto-comercial">
            <i class="fa-solid fa-arrow-left"></i> Regresar</a>
    </div>

    <form method="POST" class="formulario">

        <fieldset class="formulario__fieldset">

            <legend class="formulario__legend">Información del Producto</legend>

            <div class="formulario__campo">
                <label for="nombre" class="formulario__label">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="formulario__input" placeholder='Ej. Monten C14' value="<?php echo $producto->nombre; ?>">
            </div>

            <div class="formulario__campo">
                <label for="categoriaProducto_id" class="formulario__label">Categoria</label>
                <select class="formulario__input formulario__input--select" name="categoriaProducto_id" id="categoriaProducto_id">
                    <option value="" selected>--Seleccione una Opción--</option>
                    <?php foreach ($categorias as $categoria) { ?>
                        <option value="<?php echo $categoria->id; ?>" <?php echo $categoria->id == $producto->categoriaProducto_id ? 'selected' : ''; ?>> <?php echo $categoria->nombre; ?></option>
                    <?php } ?>
                </select>

                <a class="formulario__enlace" href="/admin/categoria">Gestionar Categorias de Producto</a>

            </div>


            <div class="formulario__contenedor">

                <p class="formulario__descripcion">¿Desea Asociar El Producto En Cuestión A Un Tipo De Acero (Costo Base)</p>

                <div class="formulario__contenedor--radios">
                    <div class="formulario__radio">
                        <label for="si" class="formulario__label">Si</label>
                        <input type="radio" name="respuesta" id="si" value="1">
                    </div>
                    <div class="formulario__radio">
                        <label for="no" class="formulario__label">No</label>
                        <input type="radio" name="respuesta" id="no" value="0">
                    </div>
                </div>


            </div>

            <input type="hidden" id="acero-hidden" value="<?php echo $producto->tiposaceros_id ?? ''; ?>">
            <input type="hidden" id="costo-hidden" value="<?php echo $producto->costo ?? ''; ?>">

            <div class="formulario__campo " id="mostrar-select-acero">

            </div>

            <div class="formulario__campo " id="mostrar-input-costo">

            </div>

        </fieldset>


        <input type="hidden" id="input-actualizar" value="<?php echo $producto->id?>">

        <div class="flex-centro">
            <input class="btn-submit" type="submit" value="actualizar producto" id="submit-actualizar">
        </div>

    </form>
</div>

<?php include_once __DIR__ . '/../../templates/footer-dashboard.php' ?>