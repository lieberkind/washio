<html>
<head>
    <meta charset="UTF-8">
    <title>Washio</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Wash<span class="io">io<span></h1>

        <h2 class="table-title">Your reservations</h2>

        <?php if(count($times) > 0): ?>

            <table class="times">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Day</th>
                        <th>Time</th>
                        <th>Location</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($times as $time): ?>
                        <tr class="time">
                            <td>
                                <?= $time->getTime()->format('d/m-Y'); ?>
                            </td>
                            <td>
                                <?= $time->getTime()->format('l'); ?>
                            </td>
                            <td>
                                <?= $time->getTime()->format('H:i'); ?>
                            </td>
                            <td>
                                <?= $time->getLocation() ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php else: ?>
            <p>There are currently no reservations</p>
        <?php endif; ?>

        <h2 class="table-title">Next 30 available washing times</h2>

        <table class="times">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Day</th>
                    <th>Time</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($availableTimes as $time): ?>
                    <tr class="time">
                        <td>
                            <?= $time->getTime()->format('d/m-Y'); ?>
                        </td>
                        <td>
                            <?= $time->getTime()->format('l'); ?>
                        </td>
                        <td>
                            <?= $time->getTime()->format('H:i'); ?>
                        </td>
                        <td>
                            <?= $time->getLocation() ?>
                        </td>

                        <td>Book this time</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <ul class="reservation-links">
            <li>
                <a target="_blank" href="http://93.163.25.78/ke.htm">Nr. 17 login &#8594;</a>
            </li>
            <li>
                <a target="_blank" href="http://93.163.45.78/ke.htm">Nr. 25 login &#8594;</a>
            </li>
        </ul>
    </div>
</body>
</html>
