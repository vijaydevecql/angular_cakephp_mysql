

<?php $i=0; foreach($setting as $row): ?>

<div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                              <?php echo $row['Setting']['type'] ?>
                                <small>you will edit the content</small>
                            </h2>
                          
                        </div>
                        <div class="body">
                            <textarea name="<?php echo $row['Setting']['type'] ?>" class="abc<?php echo $row['Setting']['id']; ?>" id="ckeditor<?php echo $i; ?>">
                                <?php echo $row['Setting']['content'] ?>
                            </textarea>
                            <button model="setting" style="margin-top:30px "  rel='<?php echo json_encode($row['Setting']) ?>' class="btn bg-light-blue  waves-effect update">Update</button>
                        </div>
                         
                    </div>
                   
                </div>
            </div>


<?php $i++; endforeach;  ?>
