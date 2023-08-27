<div class="container-fluid">
    <div class="row">
    <div class="col-sm-12">

    <div class="col-sm-7">
        <h5 style="color:#3393FF">Client Info..</h5>
        <div>Date : <strong>{{ date('d M, Y', strtotime($client->created_at)) }}</strong> </div>
        <div>
            Name : <strong>{{ $client->customers->name }} </strong>
        </div>
        <div>Phone : <strong>{{ $client->customers->primary_phone }} </strong> </div>
        <div>Email Body : <strong>{{ strip_tags($client->text) }}</strong> </div>
    </div>
    </div>
</div>
</div>
