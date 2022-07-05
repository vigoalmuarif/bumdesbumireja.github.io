      <!-- Modal -->
      <div class="modal fade" id="modalHistoryStok" tabindex="-1" aria-labelledby="stokInLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-scrollable">
              <div class="modal-content">
                  <div class="modal-header">
                      <p class="d-inline">Riwayat Stok <strong><?= $produk['produk']; ?></strong></p>

                      <button type=" button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">


                      <div class="table-responsive">
                          <table class="table table-bordered" id="tableHistoryStok" width="100%" cellspacing="0">
                              <thead>
                                  <tr>
                                      <th>No</th>
                                      <th>Tanggal</th>
                                      <th>Qty</th>
                                      <th>Stok</th>
                                      <th>Keterangan</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php
                                    $no = 1;
                                    $jumlah =  0;
                                    foreach ($stock as $stok) : ?>
                                      <tr>
                                          <td><?= $no++ ?></td>
                                          <td style="width: 110px;"><?= date('d-m-Y H:i', strtotime($stok['tanggal'])) ?></td>
                                          <td class="<?= $stok['type'] == 'in' ? 'text-success text-left' : 'text-danger text-right' ?>"><?= $stok['type'] == 'in' ? '+' : '-' ?><?= number_format($stok['qty'], 0, ".", ".") . ' ' . $stok['satuan'];; ?></td>
                                          <td><?php if ($stok['type'] == 'in') {
                                                    echo ($jumlah = $jumlah + ($stok['qty'] * $stok['isi'])) . ' ' . $satuan;
                                                } else {
                                                    echo ($jumlah = $jumlah - ($stok['qty'] * $stok['isi'])) . ' ' . $satuan;
                                                } ?>
                                          </td>

                                          <td><?= $stok['desc']; ?></td>
                                      </tr>
                                  <?php endforeach ?>

                              </tbody>
                          </table>
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                  </div>
              </div>
          </div>
      </div>

      <script>
          function deleteLastKarakter() {
              var stok = $(".stok").text();
              var a = stok.slice(0, -2);
              $(".stok").text(a);

          }
          $(document).ready(function() {
              deleteLastKarakter();
              $('#tableHistoryStok').DataTable();
          });
      </script>