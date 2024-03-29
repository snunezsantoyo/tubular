<aside class="sidebar">
    <div class="sidebar__contenedor">
        <h2 id="ferretinoco">FerreTinoco</h2>

        <div class="sidebar__cerrar-menu">
            <img id="cerrar-menu" src="/build/img/cerrar.svg" alt="imagen cerrar menu">
        </div>
    </div>


    <!--Navegación para administradores-->
    <?php if ($_SESSION['status'] === 0 || $_SESSION['status'] === 1) { ?>
        <nav class="sidebar__nav">
            <a class=" sidebar__enlace <?php echo pagina_actual('/admin') ? 'sidebar__enlace--activo' : '' ?>" href="/admin/index">Administración Global</a>
            <a class=" sidebar__enlace <?php echo pagina_actual('/perfiles') ? 'sidebar__enlace--activo' : '' ?>" href="/perfiles/index">Perfiles</a>
            <a class=" sidebar__enlace <?php echo pagina_actual('/historial') ? 'sidebar__enlace--activo' : '' ?>" href="/historial">Historial de Cambios</a>
        </nav>
    <?php } ?>

    <!--Navegación para proveedores-->
    <?php if ($_SESSION['status'] === 2) { ?>
        <nav class="sidebar__nav">
            <a class=" sidebar__enlace  <?php echo pagina_actual('/index') ? 'sidebar__enlace--activo' : '' ?>" href="/proveedor/index">Levantar Pedido</a>
            <a class=" sidebar__enlace  <?php echo pagina_actual('/clientes') ? 'sidebar__enlace--activo' : '' ?>" href="/proveedor/clientes">Clientes</a>
            <a class=" sidebar__enlace  <?php echo pagina_actual('/productos') ? 'sidebar__enlace--activo' : '' ?>" href="/proveedor/productos">Productos</a>
            <a class=" sidebar__enlace  <?php echo pagina_actual('/historial-pedidos') ? 'sidebar__enlace--activo' : '' ?>" href="/proveedor/historial-pedidos">Historial Pedidos</a>
        </nav>
    <?php } ?>

    <!--Navegación para oficina-->
    <?php if ($_SESSION['status'] === 3) { ?>
        <nav class="sidebar__nav">
            <a class=" sidebar__enlace  <?php echo pagina_actual('/oficina') ? 'sidebar__enlace--activo' : '' ?>" href="/oficina/index">Gestionar Pedidos</a>
            <a class=" sidebar__enlace  <?php echo pagina_actual('/graficar') ? 'sidebar__enlace--activo' : '' ?>" href="/pedidos/graficar">Estadísticas</a>
            <a class=" sidebar__enlace <?php echo pagina_actual('/perfiles') ? 'sidebar__enlace--activo' : '' ?>" href="/perfiles/index">Perfiles</a>
        </nav>
    <?php } ?>





    <div class="sidebar__cerrar-sesion-mobile">
        <a href="/logout" class="cerrar-sesion">Cerrar Sesión</a>
    </div>
</aside>