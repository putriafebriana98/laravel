<!DOCTYPE html>
<html>
<head>
    <title>Society data processing by using laravel</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <br/>
    <h3>Music Society data processing in Community</h3>
    <br/>
    <div align="right">
        <button type="button" name="add" id="add_data" class="btn btn-success btn-sm">Add</button>
    </div>
    <br/>
    <table id="societies_table" class="table table-bordered" style="width: 100%">
        <thead>
        <tr>
            <th>music name</th>
            <th>singer</th>
            <th>link</th>
            <th>time</th>
        </tr>
        </thead>
    </table>
</div>
<div id="modal_society" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
        <form method="post" id="form_society">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add data</h4>
            </div>
            <div class="modal-body">
                {{csrf_field()}}
                <span id="notification_after_submit"></span>
                <div class="form-group">
                    <label>Enter music name:</label>
                    <input type="text" name="music_name" id="music_name" class="form-control" />
                </div>
                <div class="form-group">
                    <label>Enter singer:</label>
                    <input type="text" name="singer" id="singer" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Link:</label>
                    <input type="text" name="link" id="link" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>time</label>
                    <input type="time" name="time" id="time" class="form-control"/>
                </div>

            </div>
            <div class="modal-footer">
                <input type="hidden" name="action_button" id="action_button" value="insert"/>
                <input type="submit" name="submit" id="submit_button" value="Submit" class="btn btn-info"/>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </form>
        </div>

    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#societies_table').DataTable({
            "processing":true,
            "serverSide":true,
            "ajax":"{{route('ajaxdata.getdata')}}",
            "columns":[
                {"data":"music_name"},
                {"data":"singer"},
                {"data":"link",
                "render":function (data,type,row,meta) {
                    if (type==='display'){
                        data='<a href="'+data+'">'+data+'</a>';
                    }
                    return data;
                }},
                {"data":"time"}
            ]
        })
    })
    $('#add_data').click(function () {
        $('#modal_society').modal('show');
        $('#form_society')[0].reset();
        $('#notification_after_submit').html('');
        $('#action_button').val('insert');
        $('#submit_button').val('add');
    })

    $('#form_society').on('submit',function (event) {
    event.preventDefault();
    var form_data=$(this).serialize();
    $.ajax({
        url:"{{route('ajaxdata.postdata')}}",
        method:"POST",
        data:form_data,
        dataType:"json",
        success:function (data) {
            if (data.error.length>0){
                var error_output='';
                for (var i=0;i<data.error.length;i++){
                    error_output+='<div class="alert alert-danger">'+data.error[i]+'</div>';
                }
                $('#notification_after_submit').html(error_output);
            }else {
                $('#notification_after_submit').html(data.success);
                $('#form_society')[0].reset();
                $('#submit_button').val('Add');
                $('.modal-title').text('Add Data');
                $('#action_button').val('insert');
                $('#societies_table').DataTable().ajax.reload();
            }
        }

    })
    })
</script>
</body>
</html>