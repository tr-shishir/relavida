 <!-- Page Header -->
 <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title"><?php _e('Subscription Product'); ?></h3><br>
            </div>
           
        </div>
    </div>


    <!-- /Page Header -->
    <!-- add subscription interval -->
    <form method="post">
        <div class="form-row">
            <div class="form-group col-md-6">
                <input type="text" name="interval" id="interval" class="form-control" placeholder="<?php _e('Subscription Time Interval'); ?>" required>
            </div>
            <div class="form-group col-md-4">
                <select id="freequency" class="form-control">
                    <option value="Day" selected><?php _e('Day'); ?></option>
                     <option value="Week"><?php _e('Week'); ?></option>
                     <option value="Month"><?php _e('Month'); ?></option>
                     <option value="Year"><?php _e('Year'); ?></option>
                </select>
            </div>
            <div class="form-group col-md-2">
                <a href="" onclick="add_new_item()" class="btn btn-primary add"><i class="fas fa-plus"></i></a>
            </div>
        </div>
    </form>
    

    <?php
        use Illuminate\Support\Facades\DB;
        $data=DB::table('subscription_items')->groupBy('sub_interval')->get();


    ?>
 <div class="row">
        <div class="col-sm-12">
        
            <div class="card card-table">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-center mb-0 datatable">
                            <thead>
                                <tr>
                                    <th><?php _e('Serial'); ?></th>
                                    <th><?php _e('Subscription Interval'); ?></th>
                                    <th><?php _e('Action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(isset($data)):  ?>
                                    <?php $i = 1;
                                    foreach($data as $data):  ?>
                                    <tr>
                                        <td><?php print $i; $i++; ?></td>
                                        <td><?php $sub_info = explode(" ", $data->sub_interval);
                                                print $sub_info[0] . ' ';
                                                _e($sub_info[1]);  ?></td>
                                        <td>
                                            <div class="actions">
                                                <!-- <a href="edit=<?php print $data->id;  ?>" class="btn btn-sm btn-success mr-2">
                                                    <i class="fas fa-pen"></i>
                                                </a> -->
                                                <a href="<?php print api_url('subscriptionDelete'); ?>?delete=<?php print $data->id; ?>" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>                          
        </div>                  
    </div>
<script>
    function add_new_item() {
        let sub_interval = $('#interval').val();
        let sub_freequency = $('#freequency').val();

        let interval=sub_interval+' '+sub_freequency;

        if (sub_interval && sub_interval>0) 
        {
            $.post("<?=api_url('save_subscription')?>", {
                sub_interval: interval
            }).then((res, err) => {
                console.log(res, err);
            });
        }

        
    }
</script>