<div class="well">
  <div class="wrap">
    <table class="table">
      <thead>
        <tr>
          <th>Ключ</th>
          <th>Значение</th>
        </tr>
      </thead>
      <tbody class="table-striped">
        <?php foreach ($user->table as $key => $value): ?>
          <tr >
            <th scope="row">
              <?= $user->getAttributeLabel($key); ?>
              <td><?= $value ?></td>
            </th>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
