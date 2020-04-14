@extends ('layouts.admin')
@section ('contenido')
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-horizontal form-label-left">

        <div class="x_title">
            <h2>Monitoreo de sitios<small></small></h2>
            <ul class="nav navbar-right panel_toolbox">

            </ul>
            <div class="clearfix"></div>
        </div>
        @if (count($errors)>0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                {!!Form::open(array('url'=>'monitor','method'=>'POST','autocomplete'=>'off'))!!}
                {{Form::token()}}

               

                <div class="table-responsive" id=response>
                    <table  class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Sistema</th>
                                <th>URL</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                            <tbody>
                                <?php
                                if (count($sitios) > 0) {
                                    for ($i = 1; $i <= count($sitios); $i++) {
                                ?>
                                        <tr>
                                            <td align="center"><?php echo $i;  ?></td>
                                            <td><?php echo $sitios[$i][1];  ?></td>
                                            <td><?php echo $sitios[$i][2];  ?></td>
                                            <td align="center"><?php if ($sitios[$i][3] == 1) {  ?>
                                                    <button class="btn btn-success">on line</button>
                                                <?php } else {  ?>
                                                    <button class="btn btn-danger">off line</button>

                                                <?php }  ?>
                                            </td>
                                        </tr>

                                <?php
                                    }
                                }
                                ?>
                            </tbody>
               
                    </table>
                </div>

            

 

                {!!Form::close()!!}


            </div>
        </div>
    </div>

</div>

<!-- jQuery 2.1.4 -->
<script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        setInterval(function() {

            $.ajax({
                type: "get",
                url: "monitor/load/1",
                data: {},
                success: function(data) {
                    console.log(data);
                    $('#response').html(data);

                }

            });


        }, 5000);


    });
</script>



@endsection