<?php $this->load->view('admin/' . $this->uri->segment(2) . '/menu') ?>
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0"><i class="fas fa-cogs me-2"></i><?= $page ?></h4>
        </div>
        <div class="card-body pb-3">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                <div class="form-group">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control" name="title_landing" value="<?= website_config('title_landing') ?>">
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="form-label">Meta Description</label>
                        <textarea class="form-control" name="meta_description_landing" rows="5"><?= website_config('meta_description_landing') ?></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Meta Keywords</label>
                        <textarea class="form-control" name="meta_keywords_landing" rows="5"><?= website_config('meta_keywords_landing') ?></textarea>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label class="form-label">Navbar Brand</label>
                    <input type="text" class="form-control" name="navbar_brand" value="<?= website_config('navbar_brand_landing') ?>">
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="form-label">Description 1</label>
                        <textarea class="form-control" name="description_1" rows="5"><?= website_config('description1_landing') ?></textarea>
                        <small class="text-muted">[ST_GRADIENT] [CL_GRADIENT]</small><br>
                        <small class="text-muted">[ST_PRIMARY] [CL_PRIMARY]</small>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Description 2</label>
                        <textarea class="form-control" name="description_2" rows="5"><?= website_config('description2_landing') ?></textarea>
                        <small class="text-muted">[ST_GRADIENT] [CL_GRADIENT]</small><br>
                        <small class="text-muted">[ST_PRIMARY] [CL_PRIMARY]</small>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label class="form-label">About Title</label>
                    <input type="text" class="form-control" name="about_title" value="<?= website_config('about_title_landing') ?>">
                </div>
                <div class="form-group ">
                    <label class="form-label">About Description</label>
                    <textarea class="form-control" name="about_description" rows="5"><?= website_config('about_description_landing') ?></textarea>
                    <small class="text-muted">[ST_GRADIENT] [CL_GRADIENT]</small><br>
                    <small class="text-muted">[ST_PRIMARY] [CL_PRIMARY]</small>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="form-label">About 1 - Title</label>
                        <input type="text" class="form-control" name="about_1_title" value="<?= website_config('about_1_title') ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">About 1 - Content</label>
                        <textarea class="form-control" name="about_1_content" rows="5"><?= website_config('about_1_content') ?></textarea>
                        <small class="text-muted">[ST_GRADIENT] [CL_GRADIENT]</small><br>
                        <small class="text-muted">[ST_PRIMARY] [CL_PRIMARY]</small>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="form-label">About 2 - Title</label>
                        <input type="text" class="form-control" name="about_2_title" value="<?= website_config('about_2_title') ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">About 2 - Content</label>
                        <textarea class="form-control" name="about_2_content" rows="5"><?= website_config('about_2_content') ?></textarea>
                        <small class="text-muted">[ST_GRADIENT] [CL_GRADIENT]</small><br>
                        <small class="text-muted">[ST_PRIMARY] [CL_PRIMARY]</small>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="form-label">About 3 - Title</label>
                        <input type="text" class="form-control" name="about_3_title" value="<?= website_config('about_3_title') ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">About 3 - Content</label>
                        <textarea class="form-control" name="about_3_content" rows="5"><?= website_config('about_3_content') ?></textarea>
                        <small class="text-muted">[ST_GRADIENT] [CL_GRADIENT]</small><br>
                        <small class="text-muted">[ST_PRIMARY] [CL_PRIMARY]</small>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label class="form-label">Feature Title</label>
                    <input type="text" class="form-control" name="feature_title" value="<?= website_config('feature_title') ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">Feature Description</label>
                    <textarea class="form-control" name="feature_description" rows="5"><?= website_config('feature_description') ?></textarea>
                    <small class="text-muted">[ST_GRADIENT] [CL_GRADIENT]</small><br>
                    <small class="text-muted">[ST_PRIMARY] [CL_PRIMARY]</small>
                </div>
                <div id="feature">

                    <?php
                    $features = $this->landing_config_model->get_rows(['where' => [['type' => 'features']]]);
                    ?>
                    <?php if ($features == false) { ?>
                        <div class="row" id="">
                            <div class="form-group col-md-5">
                                <label class="form-label">Features - Title</label>
                                <input type="text" class="form-control" name="features_title[]" required="">
                            </div>
                            <div class="form-group col-md-5">
                                <label class="form-label">Features - Content</label>
                                <textarea class="form-control" name="features_content[]" rows="5" required=""></textarea>
                                <small class="text-muted">[ST_GRADIENT] [CL_GRADIENT]</small><br>
                                <small class="text-muted">[ST_PRIMARY] [CL_PRIMARY]</small>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="form-label d-block">Features - Aksi</label>
                                <button type="button" class="btn btn-danger" onclick="remove_feature()"><i class="fas fa-trash fs-6 me-2"></i>Remove Form</button>
                            </div>
                        </div>
                    <?php } else { ?>
                        <?php foreach ($features as $key => $value) { ?>
                            <div class="row" id="form_<?= $value['id'] ?>">
                                <div class="form-group col-md-5">
                                    <label class="form-label">Features - Title</label>
                                    <input type="text" class="form-control" name="features_title[]" value="<?= $value['title'] ?>">
                                </div>
                                <div class="form-group col-md-5">
                                    <label class="form-label">Features - Content</label>
                                    <textarea class="form-control" name="features_content[]" rows="5"><?= $value['content'] ?></textarea>
                                    <small class="text-muted">[ST_GRADIENT] [CL_GRADIENT]</small><br>
                                    <small class="text-muted">[ST_PRIMARY] [CL_PRIMARY]</small>
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="form-label d-block">Features - Aksi</label>
                                    <button type="button" class="btn btn-danger" onclick="remove_feature(<?= $value['id'] ?>)"><i class="fas fa-trash fs-6 me-2"></i>Remove Form</button>
                                </div>
                            </div>

                        <?php } ?>
                    <?php } ?>
                </div>
                <div class="form-group text-end">
                    <button type="button" class="btn btn-success" onclick="add_feature()"><i class="fas fa-plus-circle fs-6 me-2"></i>Add Form</button>
                </div>
                <hr>
                <div class="form-group">
                    <label class="form-label">Testimonial Title</label>
                    <input type="text" class="form-control" name="testi_title" value="<?= website_config('testi_title') ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">Testimonial Description</label>
                    <textarea class="form-control" name="testi_description" rows="5"><?= website_config('testi_description') ?></textarea>
                    <small class="text-muted">[ST_GRADIENT] [CL_GRADIENT]</small><br>
                    <small class="text-muted">[ST_PRIMARY] [CL_PRIMARY]</small>
                </div>
                <div id="testimonial_top">

                    <?php
                    $testimonial_top = $this->landing_config_model->get_rows(['where' => [['type' => 'testimonial_top']]]);
                    ?>
                    <?php if ($testimonial_top == false) { ?>
                        <div class="row" id="">
                            <div class="form-group col-md-2">
                                <label class="form-label">Testimonial Top - Avatar</label>
                                <select class="form-control select2-data" name="testimonials_top_avatar[]" required="">
                                    <?php foreach ($avatars as $avatar) { ?>
                                        <option value="<?= $avatar ?>">
                                            <?= $avatars_labels[$avatar] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="form-label">Testimonial Top - Name</label>
                                <input type="text" class="form-control" name="testimonials_top_name[]" required="">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-label">Testimonial Top - Title</label>
                                <input type="text" class="form-control" name="testimonials_top_title[]" required="">
                            </div>
                            <div class="form-group col-md-5">
                                <label class="form-label">Testimonial Top - Content</label>
                                <textarea class="form-control" name="testimonials_top_content[]" rows="5" required=""></textarea>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="form-label d-block">Testimonial Top - Aksi</label>
                                <button type="button" class="btn btn-danger" onclick="remove_testimonial_top()"><i class="fas fa-trash fs-6 me-2"></i>Remove Form</button>
                            </div>
                        </div>
                    <?php } else { ?>
                        <?php foreach ($testimonial_top as $key => $value) { ?>
                            <div class="row" id="form_<?= $value['id'] ?>">
                                <div class="form-group col-md-2">
                                    <label class="form-label">Testimonial Top - Avatar</label>
                                    <select class="form-control select2-data" name="testimonials_top_avatar[]">
                                        <?php foreach ($avatars as $avatar) { ?>
                                            <option value="<?= $avatar ?>" <?= ($value['icon'] == $avatar) ? 'selected' : '' ?>>
                                                <?= $avatars_labels[$avatar] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="form-label">Testimonial Top - Name</label>
                                    <input type="text" class="form-control" name="testimonials_top_name[]" value="<?= $value['name'] ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="form-label">Testimonial Top - Title</label>
                                    <input type="text" class="form-control" name="testimonials_top_title[]" value="<?= $value['title'] ?>">
                                </div>
                                <div class="form-group col-md-5">
                                    <label class="form-label">Testimonial Top - Content</label>
                                    <textarea class="form-control" name="testimonials_top_content[]" rows="5"><?= $value['content'] ?></textarea>
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="form-label d-block">Testimonial Top - Aksi</label>
                                    <button type="button" class="btn btn-danger" onclick="remove_testimonial_top(<?= $value['id'] ?>)"><i class="fas fa-trash fs-6 me-2"></i>Remove Form</button>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
                <div class="form-group text-end">
                    <button type="button" class="btn btn-success" onclick="add_testimonial_top()"><i class="fas fa-plus-circle fs-6 me-2"></i>Add Form</button>
                </div>
                <hr>
                <div id="testimonial_bottom">

                    <?php
                    $testimonial_bottom = $this->landing_config_model->get_rows(['where' => [['type' => 'testimonial_bottom']]]);
                    ?>
                    <?php if ($testimonial_bottom == false) { ?>
                        <div class="row" id="">
                            <div class="form-group col-md-2">
                                <label class="form-label">Testimonial Bottom - Avatar</label>
                                <select class="form-control select2-data" name="testimonials_bottom_avatar[]" required="">
                                    <?php foreach ($avatars as $avatar) { ?>
                                        <option value="<?= $avatar ?>">
                                            <?= $avatars_labels[$avatar] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="form-label">Testimonial Bottom - Name</label>
                                <input type="text" class="form-control" name="testimonials_bottom_name[]" required="">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-label">Testimonial Bottom - Title</label>
                                <input type="text" class="form-control" name="testimonials_bottom_title[]" required="">
                            </div>
                            <div class="form-group col-md-5">
                                <label class="form-label">Testimonial Bottom - Content</label>
                                <textarea class="form-control" name="testimonials_bottom_content[]" rows="5" required=""></textarea>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="form-label d-block">Testimonial Bottom - Aksi</label>
                                <button type="button" class="btn btn-danger" onclick="remove_testimonial_bottom()"><i class="fas fa-trash fs-6 me-2"></i>Remove Form</button>
                            </div>
                        </div>
                    <?php } else { ?>
                        <?php foreach ($testimonial_bottom as $key => $value) { ?>
                            <div class="row" id="form_<?= $value['id'] ?>">
                                <div class="form-group col-md-2">
                                    <label class="form-label">Testimonial Bottom - Avatar</label>
                                    <select class="form-control select2-data" name="testimonials_bottom_avatar[]">
                                        <?php foreach ($avatars as $avatar) { ?>
                                            <option value="<?= $avatar ?>" <?= ($value['icon'] == $avatar) ? 'selected' : '' ?>>
                                                <?= $avatars_labels[$avatar] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="form-label">Testimonial Bottom - Name</label>
                                    <input type="text" class="form-control" name="testimonials_bottom_name[]" value="<?= $value['name'] ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="form-label">Testimonial Bottom - Title</label>
                                    <input type="text" class="form-control" name="testimonials_bottom_title[]" value="<?= $value['title'] ?>">
                                </div>
                                <div class="form-group col-md-5">
                                    <label class="form-label">Testimonial Bottom - Content</label>
                                    <textarea class="form-control" name="testimonials_bottom_content[]" rows="5"><?= $value['content'] ?></textarea>
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="form-label d-block">Testimonial Top - Aksi</label>
                                    <button type="button" class="btn btn-danger" onclick="remove_testimonial_bottom(<?= $value['id'] ?>)"><i class="fas fa-trash fs-6 me-2"></i>Remove Form</button>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
                <div class="form-group text-end">
                    <button type="button" class="btn btn-success" onclick="add_testimonial_bottom()"><i class="fas fa-plus-circle fs-6 me-2"></i>Add Form</button>
                </div>
                <hr>
                <div class="mb-0">
                    <button type="submit" class="btn btn-primary float-end"><i class="fas fa-edit fs-6 me-2"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    function add_feature() {
        var key = Math.floor(Math.random() * 99999);
        $('#feature').append('<div class="row" id="form_' + key + '"><div class="form-group col-md-5"><label class="form-label">Features - Title</label><input type="text" class="form-control" name="features_title[]"></div><div class="form-group col-md-5"><label class="form-label">Features - Content</label><textarea class="form-control" name="features_content[]" rows="5"></textarea><small class="text-muted">[ST_GRADIENT] [CL_GRADIENT]</small><br><small class="text-muted">[ST_PRIMARY] [CL_PRIMARY]</small></div><div class="form-group col-md-2"><label class="form-label d-block">Features - Aksi</label><button type="button" class="btn btn-danger" onclick="remove_feature(' + key + ')"><i class="fas fa-trash fs-6 me-2"></i>Remove Form</button></div></div>');
    }

    function remove_feature(key) {
        $('#form_' + key).remove();
    }

    function add_testimonial_top() {
        var key = Math.floor(Math.random() * 99999);
        var formHtml = `<div class="row" id="form_${key}">
                            <div class="form-group col-md-2">
                                <label class="form-label">Testimonial Top - Avatar</label>
                                <select class="form-control select2-data" name="testimonials_top_avatar[]">
                                    ${generateAvatarOptions()}
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="form-label">Testimonial Top - Name</label>
                                <input type="text" class="form-control" name="testimonials_top_name[]">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-label">Testimonial Top - Title</label>
                                <input type="text" class="form-control" name="testimonials_top_title[]">
                            </div>
                            <div class="form-group col-md-5">
                                <label class="form-label">Testimonial Top - Content</label>
                                <textarea class="form-control" name="testimonials_top_content[]" rows="5"></textarea>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="form-label d-block">Testimonial Top - Aksi</label>
                                <button type="button" class="btn btn-danger" onclick="remove_testimonial_top(${key})">
                                    <i class="fas fa-trash fs-6 me-2"></i>Remove Form
                                </button>
                            </div>
                        </div>`;

        $('#testimonial_top').append(formHtml);
    }

    function generateAvatarOptions() {
        var optionsHtml = '';
        <?php foreach ($avatars as $avatar) { ?>
            optionsHtml += `<option value="<?= $avatar ?>"><?= $avatars_labels[$avatar] ?></option>`;
        <?php } ?>
        return optionsHtml;
    }

    function remove_testimonial_top(key) {
        $('#form_' + key).remove();
    }


    function add_testimonial_bottom() {
        var key = Math.floor(Math.random() * 99999);
        var formHtml = `<div class="row" id="form_${key}">
                            <div class="form-group col-md-2">
                                <label class="form-label">Testimonial Bottom - Avatar</label>
                                <select class="form-control select2-data" name="testimonials_bottom_avatar[]">
                                    ${generateAvatarOptions()}
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="form-label">Testimonial Bottom - Name</label>
                                <input type="text" class="form-control" name="testimonials_bottom_name[]">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-label">Testimonial Bottom - Title</label>
                                <input type="text" class="form-control" name="testimonials_bottom_title[]">
                            </div>
                            <div class="form-group col-md-5">
                                <label class="form-label">Testimonial Bottom - Content</label>
                                <textarea class="form-control" name="testimonials_bottom_content[]" rows="5"></textarea>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="form-label d-block">Testimonial Bottom - Aksi</label>
                                <button type="button" class="btn btn-danger" onclick="remove_testimonial_bottom(${key})">
                                    <i class="fas fa-trash fs-6 me-2"></i>Remove Form
                                </button>
                            </div>
                        </div>`;

        $('#testimonial_bottom').append(formHtml);
    }

    function remove_testimonial_bottom(key) {
        $('#form_' + key).remove();
    }
</script>