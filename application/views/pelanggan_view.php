<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Latihan CRUD</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>">
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/jquery/jquery-3.3.1.min.js"></script>
    <!--load datepicker -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jquery-ui/jquery-ui.css">
    <script src="<?php echo base_url(); ?>assets/jquery-ui/jquery-ui.js"></script>
    <!--load tinyMce -->
    <script src="<?php echo base_url('assets/tinymce/tinymce.min.js') ?>"></script>
    <script>
        tinymce.init({
            selector: 'textarea#editor1',
            theme: 'modern',
            plugins: 'print preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern help',
            toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
            image_advtab: true,
            templates: [{
                    title: 'Test template 1',
                    content: 'Test 1'
                },
                {
                    title: 'Test template 2',
                    content: 'Test 2'
                }
            ],
            setup: function(ed) {
                ed.on("change", function(e) {
                    $("#satu").val(tinymce.activeEditor.getContent());
                });
                ed.on("keyup", function() {
                    $("#satu").val(tinymce.activeEditor.getContent());
                });
            },
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tinymce.com/css/codepen.min.css'
            ]
        });
    </script>
</head>

<body>
    <div>

        <div class="col-md-10">
            <div>
                <h3>Manajemen <small class="text-muted">Data Pelanggan</small></h3>
            </div>

            <button type="button" class="btn btn-success btn-lg" onclick="add_pelanggan()"> Add Data</button>
            <button type="button" class="btn btn-info btn-lg" onclick="reload_table()"> Reload</button>
            <br />
            <br />
            <table id="table" class="display table table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nomor Pelanggan</th>
                        <th>Nama Pelanggan</th>
                        <th>Jenis Keangotaan</th>
                        <th>Telp</th>
                        <th></th>
                    </tr>
                </thead>
            </table>
        </div>

        <script src="<?= base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/DataTables/datatables.min.css" />
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/DataTables/datatables.min.js"></script>
        <script type="text/javascript">
            var save_method;
            var table;
            $(document).ready(function() {

                //datatables
                table = $('#table').DataTable({
                    responsive: true,
                    "processing": true,
                    "serverSide": true,
                    "order": [],
                    "ajax": {
                        "url": "<?php echo site_url('pelanggan/ajax_list') ?>",
                        "type": "POST"
                    },

                    "columnDefs": [{
                        "targets": [-1],
                        "orderable": false,
                    }, ],
                });

                //datepicker
                $('.datepicker').datepicker({
                    dateFormat: "yy-mm-dd",
                    changeMonth: true,
                    changeYear: true
                });

                //set input/textarea/select event when change value, remove class error and remove text help block 
                $("input").change(function() {
                    $(this).parent().parent().removeClass('has-error');
                    $(this).next().empty();
                });
                $("textarea").change(function() {
                    $(this).parent().parent().removeClass('has-error');
                    $(this).next().empty();
                });
                $("select").change(function() {
                    $(this).parent().parent().removeClass('has-error');
                    $(this).next().empty();
                });

            });

            function Copydata() {
                $("#satu").val($("#editor1").val());
            }

            function add_pelanggan() {
                save_method = 'add';
                $('#form')[0].reset();
                $('.form-group').removeClass('has-error');
                $('.help-block').empty();
                $('#modal_form').modal('show');
                $('.modal-title').text('Add Data');
            }

            function edit_pelanggan(id) {
                save_method = 'update';
                $('#form')[0].reset(); // reset form on modals
                $('.form-group').removeClass('has-error'); // clear error class
                $('.help-block').empty(); // clear error string
                //Ajax Load data from ajax
                $.ajax({
                    url: "<?php echo site_url('pelanggan/ajax_edit/') ?>/" + id,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        $('[name="id_pelanggan"]').val(data.id_pelanggan);
                        $('[name="nomor_pelanggan"]').val(data.nomor_pelanggan);
                        $('[name="nama_pelanggan"]').val(data.nama_pelanggan);
                        $('[name="jenis_keanggotaan"]').val(data.jenis_keanggotaan);
                        $('[name="alamat"]').val(data.alamat);
                        $('[name="telp"]').val(data.telp);
                        $('[name="tgl_lahir"]').val(data.tgl_lahir);
                        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                        $('.modal-title').text('Edit Data'); // Set title to Bootstrap modal title
                        tinymce.get('editor1').setContent(data.alamat);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error get data from ajax');
                    }
                });
            }

            function reload_table() {
                table.ajax.reload(null, false);
            }

            function save() {
                $('#btnSave').text('saving...');
                $('#btnSave').attr('disabled', true);
                var url;
                if (save_method == 'add') {
                    url = "<?php echo site_url('pelanggan/ajax_add') ?>";
                } else {
                    url = "<?php echo site_url('pelanggan/ajax_update') ?>";
                }

                $.ajax({
                    url: url,
                    type: "POST",
                    data: $('#form').serialize(),
                    dataType: "JSON",
                    success: function(data) {
                        if (data.status) {
                            $('#modal_form').modal('hide');
                            reload_table();
                        } else {
                            for (var i = 0; i < data.inputerror.length; i++) {
                                $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error');
                                $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]);
                            }
                        }
                        $('#btnSave').text('save');
                        $('#btnSave').attr('disabled', false);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error adding / update data');
                        $('#btnSave').text('save');
                        $('#btnSave').attr('disabled', false);
                    }
                });
            }

            function delete_pelanggan(id) {
                if (confirm('Are you sure delete this data?')) {
                    // ajax delete data to database
                    $.ajax({
                        url: "<?php echo site_url('pelanggan/ajax_delete') ?>/" + id,
                        type: "POST",
                        dataType: "JSON",
                        success: function(data) {
                            $('#modal_form').modal('hide');
                            reload_table();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert('Error deleting data');
                        }
                    });
                }
            }
        </script>

        <!-- Modal -->
        <div class="modal fade" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_form">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="#" id="form" class="form-horizontal">
                            <input type="hidden" value="" name="id_pelanggan" />
                            <div class="row">
                                <div class="col-md-6">
                                    <fieldset class="form-group">
                                        <label class="form-label">Nomor Pelanggan</label>
                                        <input name="nomor_pelanggan" placeholder="Nomor Pelanggan" class="form-control form-control-blue-fill" type="text">
                                        <font color="red"><span class="help-block"></span></font>
                                    </fieldset>

                                    <fieldset class="form-group">
                                        <label class="form-label">Nama Pelanggan</label>
                                        <input name="nama_pelanggan" placeholder="Nama Pelanggan" class="form-control form-control-blue-fill" type="text">
                                        <font color="red"><span class="help-block"></span></font>
                                    </fieldset>

                                    <fieldset class="form-group">
                                        <label class="form-label">Jenis Keanggotaan</label>
                                        <select name="jenis_keanggotaan" class="form-control form-control-blue-fill">
                                            <option value="">--Jenis Keanggotaan--</option>
                                            <option value="Diamond">Diamond</option>
                                            <option value="Silver">Silver</option>
                                            <option value="Gold">Gold</option>
                                        </select>
                                        <font color="red"><span class="help-block"></span></font>
                                    </fieldset>
                                </div>

                                <div class="col-md-6">
                                    <fieldset class="form-group">
                                        <label class="form-label">Telp</label>
                                        <input name="telp" placeholder="Telp" class="form-control form-control-blue-fill" type="text">
                                        <font color="red"><span class="help-block"></span></font>
                                    </fieldset>

                                    <fieldset class="form-group">
                                        <label class="form-label">Tanggal Lahir</label>
                                        <input name="tgl_lahir" placeholder="yyyy-mm-dd" class="form-control datepicker" type="text">
                                        <font color="red"><span class="help-block"></span></font>
                                    </fieldset>
                                </div>

                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        <label class="form-label">Alamat</label>
                                        <textarea name="editor1" id="editor1" placeholder="Alamat" class="form-control form-control-blue-fill"></textarea>
                                        <textarea id="satu" name="alamat" style="display:none;"></textarea>
                                    </fieldset>
                                </div>

                            </div>
                            <!--.row-->
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>