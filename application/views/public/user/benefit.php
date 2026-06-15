<div class="benefit-details">
    <div class="card pc-user-card mb-3" style="background: rgba(var(--bs-primary-rgb), 0.2); border-color: var(--bs-primary) !important;">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <img src="<?= base_url() ?>uploads/profil/<?= user('foto') ?>" alt="user-<?= user('username') ?>" class="user-avtar wid-45 rounded-circle">
                </div>
                <div class="flex-grow-1 ms-3 me-2">
                    <h6 class="mb-0"><?= $benefit_info['title'] ?></h6>
                    <small>
                        <?php
                        $currentBenefit = user('benefit');
                        $currentPage = $benefit_info['title'];

                        $benefitOrder = ['Silver', 'Gold', 'Platinum', 'Diamond'];
                        $currentBenefitIndex = array_search($currentBenefit, $benefitOrder);
                        $currentPageIndex = array_search($currentPage, $benefitOrder);

                        if ($currentBenefitIndex === false || $currentPageIndex === false) {
                            echo 'Keterangan tidak tersedia';
                        } elseif ($currentPageIndex < $currentBenefitIndex) {
                            echo 'Level Sebelumnya';
                        } elseif ($currentPageIndex > $currentBenefitIndex) {
                            echo 'Level Selanjutnya';
                        } else {
                            echo 'Level Saat ini';
                        }
                        ?>
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Bagian dengan keterangan "Next Level" -->
    <?php if ($currentPageIndex > $currentBenefitIndex) : ?>
        <h5 class="mb-1 text-primary">NEXT LEVEL <?= strtoupper($next_benefit_info['title']) ?></h5>
        <ul class="mb-3">
            <li>Raih <b><em>total transaksi</em></b> sebesar <b><em>Rp <?= currency($next_benefit_info['trx']) ?></em></b> untuk ke <b><em><?= $next_benefit_info['title'] ?>.</em></b></li>
            <li>Total pesanan Anda <b><em>Rp <?= currency($total_order[0]['total_rupiah']) ?></em></b> dari <b><em>Rp <?= currency($next_benefit_info['trx']) ?></em></b></li>
            <?php
            $progress = ($total_order[0]['total_rupiah'] / $next_benefit_info['trx']) * 100;
            echo '<li><b><em>Progress</em></b> Anda saat ini adalah <b><em>' . number_format($progress, 2) . '%.</em></b></li>';
            ?>
        </ul>
    <?php endif; ?>



    <!-- Bagian yang sesuai dengan tampilan benefits -->
    <h5 class="mb-1 text-primary">BENEFIT AKUN <?= strtoupper($next_benefit_info['title']) ?></h5>
    <ul class="mb-3">
        <li>Setiap <b><em>Rp <?= currency(website_config('benefit_trx')) ?></em></b> total transaksi, Anda akan mendapatkan <b><em>1 point.</em></b></li>
        <li>Rate Payout <b><em>1 Point ≈ Rp <?= $benefit_info['rate_payout'] ?>.</em></b></li>
        <li>Minimum payout <b><em><?= $benefit_info['min_payout'] ?> points.</em></b></li>
    </ul>

    <!-- Bagian yang sesuai dengan contoh perhitungan -->
    <h5 class="mb-1 text-primary">CONTOH PERHITUNGAN</h5>
    <ul class="mb-3">
        <?php
        $ratePayout = $benefit_info['rate_payout'];
        $totalPoints = 500;
        $totalPayout = $totalPoints * $ratePayout;
        ?>
        <li>
            Jika Anda melakukan payout <b><em><?= $totalPoints ?> point</em></b>, dengan rate per point Anda saat ini adalah <b><em>Rp <?= $ratePayout ?></em></b>,
            maka <b><em><?= $totalPoints ?> point x Rp <?= $ratePayout ?> = Rp <?= currency($totalPayout) ?></em></b>.
        </li>
    </ul>
    <hr>

    <div class="row">
        <div class="col-md-12">
            <!-- Menyesuaikan kondisi button Previous dan Next sesuai dengan benefit level -->
            <?php if ($prev_benefit !== 'null') : ?>
                <button type="button" class="btn btn-danger bg-gradient float-start" style="margin-bottom: -.5rem !important;" onclick="level_detail('<?= $prev_benefit ?>');">&laquo; Previous</button>
            <?php else : ?>
                <button type="button" class="btn btn-danger bg-gradient float-start" style="margin-bottom: -.5rem !important;" disabled>&laquo; Previous</button>
            <?php endif; ?>

            <?php if ($next_benefit !== 'null') : ?>
                <button type="button" class="btn btn-primary bg-gradient float-end" style="margin-bottom: -.5rem !important;" onclick="level_detail('<?= $next_benefit ?>');">Next &raquo;</button>
            <?php else : ?>
                <button type="button" class="btn btn-primary bg-gradient float-end" style="margin-bottom: -.5rem !important;" disabled>Next &raquo;</button>
            <?php endif; ?>
        </div>
    </div>
</div>