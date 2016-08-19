
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
<link href="../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
<link href="../assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
<link href="../assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />

<div class="tab-pane active" id="tab_1_1">
    @if(!count($my_group) == 0)

<table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
    <thead>
    <tr>
        <th>
            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" />
                <span></span>
            </label>
        </th>
        <th> № </th>
        <th> Имя группы </th>
        <th> Имя магазина </th>
        <th> Сумма (руб.) </th>
        <th> Скидка (%)</th>
        <th> Действие</th>
    </tr>
    </thead>
    <tbody>
    {{-- */$x=0;/* --}}
    @foreach($my_group as $item)
        {{-- */$x++;/* --}}
        <tr class="odd gradeX">
            <td>
                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                    <input type="checkbox" class="checkboxes" value="1" />
                    <span></span>
                </label>
            </td>
            <td> {{ $x }} </td>

            <td><a href="/single-group/{{$item->id}}">{{$item->group_name}}</a></td>

            <td class="center"> {{$item->getCompany->company_name}} </td>

            <td>
                {{$item->money}}
            <td>
                {{$item->discount}}
            </td>
            <td>
               какое то действие
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

    @else
        У вас нет не дной группы.
    @endif
</div>



<script src="../assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="../assets/global/scripts/app.min.js" type="text/javascript"></script>
<script src="../assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>