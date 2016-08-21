<style>
td, th {
    border: 1px solid #DDDDDD;
    padding:3px;
}
.center {
    text-align:center;
}
</style>

<a href="/">Desk Home page</a>

<hr />

<table>

   <tr>
        <th>job id</th>
        <th>candidate name</th>
        <th>candidate email</th>
        <th>candidate link</th>
        <th>referrer</th>
        <th>datetime</th>
   </tr> 

@foreach ($applications as $application)
   <tr>
        <td class="center">{{$application['jobid']}}</td>
        <td>{{$application['name']}}</td>
        <td>{{$application['email']}}</td>
        <td>{{$application['link']}}</td>
        <td>{{$application['referrer']}}</td>
        <td>{{$application['datetime']}}</td>
   </tr>

@endforeach

</table>

