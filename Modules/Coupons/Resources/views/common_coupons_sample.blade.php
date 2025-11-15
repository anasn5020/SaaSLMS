<table>
    <thead>
    <tr>
        <th>Title</th>
        <th>Code</th>
        <th>Minimum Purchase</th>
        <th>Max Discount</th>
        <th>Amount</th>
        <th>Type</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Limit</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Coupon 001</td>
        <td>save50</td>
        <td>5</td>
        <td>50</td>
        <td>50</td>
        <td>Percentage</td>
        <td>{{\Carbon\Carbon::now()->format('m/d/Y')}}</td>
        <td>{{\Carbon\Carbon::now()->addDays(30)->format('m/d/Y')}}</td>
        <td>1</td>
    </tr>
    </tbody>
</table>
