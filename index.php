<?php

if ($recent_query && $recent_query->num_rows > 0) {

    /*
    Recent records display numbering.
    Latest record = 5, then 4, 3, 2, 1.
    Actual database ID display nahi hoga.
    */

    $display_id = $recent_query->num_rows;

    while ($row = $recent_query->fetch_assoc()) {

        $severity_class = strtolower($row["severity"]);

        echo "<tr>";

        /* DISPLAY NUMBER */
        echo "<td>" . $display_id . "</td>";

        echo "<td>" .
             htmlspecialchars($row["crime_type"]) .
             "</td>";

        echo "<td>" .
             htmlspecialchars($row["location"]) .
             "</td>";

        echo "<td>" .
             htmlspecialchars($row["crime_date"]) .
             "</td>";

        echo "<td class='" .
             htmlspecialchars($severity_class) .
             "'>" .
             htmlspecialchars($row["severity"]) .
             "</td>";

        echo "</tr>";

        $display_id--;
    }

} else {

    echo "<tr>";

    echo "<td colspan='5'>
          No crime records available.
          </td>";

    echo "</tr>";
}

?>
