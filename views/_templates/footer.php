       
    <!-- Contenido   <script src="https://framework-gb.cdn.gob.mx/gobmx.js"></script>  -->
    <script src="<?php echo assets(); ?>js/plugins/gobmx.js"></script>
    <!-- Contenido para el calendario  <script src="https://framework-gb.cdn.gob.mx/assets/scripts/jquery-ui-datepicker.js"></script>  -->
    <script src="<?php echo assets(); ?>js/plugins/jquery-ui-datepicker.js"></script>
    <!-- JS -->
    <script>
        const base_url= "<?php echo base_url(); ?>";
    </script>
    <!-- SCRIPTS -->
    
    <script type="text/javascript" src="<?php echo assets(); ?>js/plugins/datatables.min.js"></script>
    <!--  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
    <script src="<?php echo assets(); ?>js/plugins/sweetalert2@11.js"></script>
    <!-- cargar scripts correspondientes a cada vista-->
    <?php
        if(empty($data['page_scripts'])){
            $data['page_scripts']='';
        }
        echo $data['page_scripts'];
    /*
    if($data['page_id'] == 'p_roles'){
        echo '<script src="'.assets().'js/roles-tab.js"></script>';
    }
    if($data['page_id'] == 'p_registro' ){
        echo '<script src="'.assets().'js/validar-reg.js"></script>';
        echo '<script type="text/javascript" src="'.assets().'js/plugins/bootstrap-select.min.js"></script>';
        echo '<script type="text/javascript" src="'.assets().'js/validaForm.js"></script>';
    }
    if($data['page_id'] == 'p_primero' ){
        echo '<script src="'.assets().'js/validar-reg1.js"></script>';
        echo '<script type="text/javascript" src="'.assets().'js/plugins/bootstrap-select.min.js"></script>';
        echo '<script type="text/javascript" src="'.assets().'js/validaForm.js"></script>';
    }
    if($data['page_id'] == 'p_usuarios'){
        echo '<script src="'.assets().'js/usuarios-tab.js"></script>';
        echo '<script type="text/javascript" src="'.assets().'js/plugins/bootstrap-select.min.js"></script>';   
        echo '<script type="text/javascript" src="'.assets(),'js/validaForm.js"></script>';
    }
    if($data['page_id'] == 'p_cargos'){
        echo '<script src="'.assets().'js/cargos-tab.js"></script>';
    }
    if($data['page_id'] == 'p_titulos'){
        echo '<script src="'.assets().'js/titulos-tab.js"></script>';
    }
    if($data['page_id'] == 'p_minutas'){
        echo '<script src="'.assets().'js/minutas.js"></script>';
        echo '<script type="text/javascript" src="'.assets().'js/plugins/bootstrap-select.min.js"></script>'; 
    }
    if($data['page_id'] == 'p_listaMin'){
        echo '<script src="'.assets().'js/minutas-tab.js"></script>';
        echo '<script type="text/javascript" src="'.assets().'js/plugins/bootstrap-select.min.js"></script>'; 
    }
*/
?>
     
    </body>
</html>