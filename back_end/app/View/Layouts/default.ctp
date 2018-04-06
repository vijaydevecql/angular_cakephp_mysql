<!DOCTYPE html>
<html>

    <?php echo $this->element('admin_head') ?>

    <body class="theme-red">
        <!-- Page Loader -->
      
        <!-- #END# Page Loader -->
        <!-- Overlay For Sidebars -->
      
        <!-- #END# Overlay For Sidebars -->
        <!-- Search Bar -->
        
        <!-- #END# Search Bar -->
        <!-- Top Bar -->
        <?php //echo $this->element('nav'); ?>
        <!-- #Top Bar -->
        <?php //echo $this->element('sidebar'); ?>

        <section class="content">
            <div class="container-fluid">
               
                <br />
                <?php echo $this->Flash->render(); ?>

                <?php echo $this->fetch('content'); ?>
            </div>
        </section>
        

        <?php echo $this->element('script') ?>
    </body>

</html>