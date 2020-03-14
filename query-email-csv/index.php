<html>
    <body>
    <h1>Search ORSEE Participants from CSV</h1>
<?php

$maxrows_default = 10;
$skiprows_default = 0;
$target_default='https://econlab.econ.ucsb.edu/orsee/admin/participants_show.php';

$maxrows = empty($_REQUEST['maxrows']) ? $maxrows_default : $_REQUEST['maxrows'];
$skiprows = empty($_REQUEST['skiprows']) ? $skiprows_default : $_REQUEST['skiprows'];
$target = empty($_REQUEST['target']) ? $target_default : $_REQUEST['target'];

$i = 0; // printing counter
$j = 0; // reading (from CSV file) counter

?>
<h2>Parameter selection</h2>
<form action="index.php" method="get">
<table>
    <tr>
        <td>maxrows</td>
        <td><input type="text" size="8" name="maxrows" value="<?php echo $maxrows ?>" /></td>
    </tr>
    <tr>
        <td>skiprows</td>
        <td><input type="text" size="8" name="skiprows" value="<?php echo $skiprows ?>" /></td>
    </tr>
    <tr>
        <td>target</td>
        <td><input type="text" size="72" name="target" value="<?php echo $target ?>" /></td>
    </tr>
</table>
<input type="submit" value="Update parameters for query below" />
</form>
<h2>Query constructor</h2>
<p><strong>Note:</strong> You must first log-in to the ORSEE admin website.</p>
<h3>Parameter values</h3>
<table>
    <tr>
        <td>maxrows</td>
        <td><?php echo $maxrows ?></td>
    </tr>
    <tr>
        <td>skiprows</td>
        <td><?php echo $skiprows ?></td>
    </tr>
    <tr>
        <td>target</td>
        <td><?php echo $target ?></td>
    </tr>
</table>
<h3>Form input values</h3>
<form action="https://econlab.econ.ucsb.edu/orsee/admin/participants_show.php" method="post">
    <table>
        <tr>
            <td>form[query][<?php echo $i; ?>][bracket_open][type]</td>
            <td><input type="text" size="48" name="form[query][<?php echo $i; ?>][bracket_open][type]" value="open" /></td>
        </tr>
        <tr><td style="background-color: gray;"></td><td></td></tr>
<?php

if (($handle = fopen("emails.csv", "r")) !== FALSE) {

    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

        // increment read counter
        $j++;

        // skip the first $skiprows rows
        if ($j <= $skiprows) continue;

        // increment print counter
        $i++;

        // only construct for first $maxrows rows
        if ($i > $maxrows) break;

        if ($i > 1) {
            echo <<<EOF
        <tr>
            <td>form[query][{$i}][pformtextfields_freetextsearch][logical_op]</td>
            <td><input type="text" size="48" name="form[query][{$i}][pformtextfields_freetextsearch][logical_op]" value="or" /></td>
        </tr>

EOF;
        };

        echo <<<EOF
        <tr>
            <td>form[query][{$i}][pformtextfields_freetextsearch][search_string]</td>
            <td><input type="text" size="48" name="form[query][{$i}][pformtextfields_freetextsearch][search_string]" value="{$data[0]}" /></td>
        <tr>
            <td>form[query][{$i}][pformtextfields_freetextsearch][search_field]</td>
            <td><input type="text" size="48" name="form[query][{$i}][pformtextfields_freetextsearch][search_field]" value="email" /></td>
        </tr>
        <tr>
            <td>form[query][{$i}][pformtextfields_freetextsearch][not]</td>
            <td><input type="text" size="48" name="form[query][{$i}][pformtextfields_freetextsearch][not]" value="" /></td>
        </tr>
        <tr><td style="background-color: gray;"></td><td></td></tr>

EOF;

    };

    // close csv file
    fclose($handle);

};

?>
        <tr>
            <td>form[query][<?php echo $i; ?>][bracket_close][type]</td>
            <td><input type="text" size="48" name="form[query][<?php echo $i; ?>][bracket_close][type]" value="close" /></td>
        </tr>
        <tr><td style="background-color: gray;"></td><td></td></tr>
<?php $i++; ?>
        <tr>
            <td>form[query][<?php echo $i; ?>][statusids_multiselect][logical_op]</td>
            <td><input type="text" size="48" name="form[query][<?php echo $i; ?>][statusids_multiselect][logical_op]" value="and" /></td>
        </tr>
        <tr>
            <td>form[query][<?php echo $i; ?>][statusids_multiselect][not]</td>
            <td><input type="text" size="48" name="form[query][<?php echo $i; ?>][statusids_multiselect][not]" value="" /></td>
        </tr>
        <tr>
            <td>form[query][<?php echo $i; ?>][statusids_multiselect][ms_status]</td>
            <td><input type="text" size="48" name="form[query][<?php echo $i; ?>][statusids_multiselect][ms_status]" value="1" /></td>
        </tr>
        <tr><td style="background-color: gray;"></td><td></td></tr>
<?php $i++; ?>
        <tr>
            <td>form[query][<?php echo $i; ?>][pform_numberselect_begin_of_studies][logical_op]</td>
            <td><input type="text" size="48" name="form[query][<?php echo $i; ?>][pform_numberselect_begin_of_studies][logical_op]" value="and" /></td>
        </tr>
        <tr>
            <td>form[query][<?php echo $i; ?>][pform_numberselect_begin_of_studies][sign]</td>
            <td><input type="text" size="48" name="form[query][<?php echo $i; ?>][pform_numberselect_begin_of_studies][sign]" value="<=" /></td>
        </tr>
        <tr>
            <td>form[query][<?php echo $i; ?>][pform_numberselect_begin_of_studies][fieldvalue]</td>
            <td><input type="text" size="48" name="form[query][<?php echo $i; ?>][pform_numberselect_begin_of_studies][fieldvalue]" value="2015" /></td>
        </tr>
        <tr><td style="background-color: gray;"></td><td></td></tr>
        <tr>
            <td>search_submit</td>
            <td><input type="text" size="48" name="search_submit" value="true" /></td>
        </tr>
    </table>
    <input type="submit" />
</form>
</body>
</html>

