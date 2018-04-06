<?php //prx($this->params->params);    ?>


<div class="row clearfix">
    <!-- Basic Example -->
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>Folder Name</h2>

            </div>
            <div class="body" onclick="go(1);" >
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        <div class="item active">
                            <img src="<?php echo $this->webroot ?>images/image-gallery/11.jpg" />
                        </div>
                        <div class="item">
                            <img src="<?php echo $this->webroot ?>images/image-gallery/12.jpg" />
                        </div>
                        <div class="item">
                            <img src="<?php echo $this->webroot ?>images/image-gallery/19.jpg" />
                        </div>
                    </div>

                    <!-- Controls -->
                    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Basic Example -->
    <!-- With Captions -->
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>Folder Name</h2>
                <ul class="header-dropdown m-r--5">

                </ul>
            </div>
            <div class="body" onclick="go(1);" >
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        <div class="item active">
                            <img src="<?php echo $this->webroot ?>images/image-gallery/11.jpg" />
                        </div>
                        <div class="item">
                            <img src="<?php echo $this->webroot ?>images/image-gallery/12.jpg" />
                        </div>
                        <div class="item">
                            <img src="<?php echo $this->webroot ?>images/image-gallery/19.jpg" />
                        </div>
                    </div>

                    <!-- Controls -->
                    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# With Captions -->
</div>
</div>
</section>

<script>
    function go(type) {

        window.location = "<?php echo $this->webroot ?>admin/users/all_images/type";

    }


</script>