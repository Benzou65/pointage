<?php
echo    "<tr>
            <td>" . htmlspecialchars($donnees['user_first_name']) . "</td>
            <td>" . htmlspecialchars($donnees['user_name']) . "</td>
            <td>" . $donnees['morning_hour'] . "</td>
            <td>" . $donnees['afternoon_hour'] . "</td>
        </tr>";