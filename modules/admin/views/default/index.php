<?php
/**
 * @var $data array
 */

?>

<?php foreach ($data as $item): ?>
    <h2 style="position: sticky; top: 51px; background: white"><?= array_shift($item) ?></h2>
    <table class="table" style="margin-bottom: 100px; width: auto">
        <thead>
        <tr>
            <?php foreach (array_shift($item) as $column) : ?>
                <th><?= $column ?></th>
            <?php endforeach ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($item as $row): ?>
            <?php if (is_array($row)): ?>
                <tr>
                    <?php foreach ($row as $cell): ?>
                        <td><?= $cell ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endif; ?>
        <?php endforeach ?>
        </tbody>
    </table>
<?php endforeach ?>
