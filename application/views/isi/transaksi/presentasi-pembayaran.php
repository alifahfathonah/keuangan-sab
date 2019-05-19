
<table id="simple-table" class="table table-striped table-bordered table-hover">
    <thead>
    
        <tr>
            <th class="center" rowspan="2" style="width:120px;">Kelas</th>
        <?php
            foreach($durasi as $item)
            {
                echo '<th class="center" colspan="2">Tgl '.$item.'</th>';
            }
        ?>
            <th class="center" colspan="2">Total<br>Sudah Bayar</th>
            <th class="center" colspan="2">Belum</th>
            <th class="center" colspan="2">Keseluruhan</th>
        </tr>
        <tr>
            <?php
            foreach($durasi as $item)
            {
            ?>
                <th>Jlh</th>
                <th>%</th>
            <?php
            }
            ?>
            <th>Jlh</th>
            <th>%</th>
            <th>Jlh</th>
            <th>%</th>
            <th>Jlh</th>
            <th>%</th>
        </tr>
    </thead>
    <tbody>
    <?php
    foreach($lv as $k => $v)
    {
        echo '<tr>';
        echo '<th style="background:#ddd;border-bottom:1px solid #888" colspan="'.((count($durasi))+10).'">'.strtoupper($k).'</th>';
        echo '</tr>';
        foreach($v as $ii =>$vv)
        {
            foreach($kelas[$vv] as $index => $value)
            {
                echo '<tr>';
                echo '<td><b>'.$value->nama_batch.'</b></td>';
                echo '</tr>';
            }
        }
    }
    ?>
    </tbody>
</html>
<style>
th,td
{
    font-size:11px;
}
</style>