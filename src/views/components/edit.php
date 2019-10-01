<script type="text/x-template" id="template-edit">
    <div class="edit">
        <div class="col-sm-10 offset-sm-2">
            <div class="space-between">
                <h1 v-if="id == 0">Add new</h1>
                <h1 v-else>Edit</h1>
                <div class="btn btn-primary align-self-flex-start" v-on:click="back(false)">Back</div>
            </div>
        </div>
        <div v-for="(field, index) in menu_item.fields" class="row form-group" v-if="field.is_visible">
            <label class="col-sm-2 control-label" v-text="field.title"></label>
            <div class="col-sm-10">
                <div v-if="field.type == 'text'">
                    <input class="form-control" type="text" v-model="fields_instance[field.db_title]" v-on:change="errors[field.db_title] = ''">
                </div>
                <div v-else-if="field.type == 'textarea'">
                    <textarea class="form-control" v-model="fields_instance[field.db_title]"></textarea>
                </div>
                <div v-else-if="field.type == 'ckeditor'">
                    <ckeditor :config="editorConfig" :editor="editor" class="form-control" v-model="fields_instance[field.db_title]"></ckeditor>
                </div>
                <div v-else-if="field.type == 'checkbox'">
                    <input class="form-control form-control-checkbox" type="checkbox" v-model="fields_instance[field.db_title]">
                </div>
                <div v-else-if="field.type == 'color'">
                    <input class="form-control colorpicker" type="text" :id="field.db_title" v-on:change="errors[field.db_title] = ''">
                </div>
                <div v-else-if="field.type == 'date'">
                    <input class="form-control datepicker" data-init="0" type="text" :id="field.db_title" v-on:change="errors[field.db_title] = ''">
                </div>
                <div v-if="field.type == 'enum'">
                    <select class="form-control" v-model="fields_instance[field.db_title]">
                        <option :value="field.enum[index]" v-for="(item, index) in field.enum" v-text="field.enum[index]"></option>
                    </select>
                </div>
                <div v-else-if="field.type == 'relationship'">
                    <select v-if="field.relationship_count == 'single'" class="form-control" v-model="fields_instance['id_' + field.relationship_table_name]">
                        <option :value="item.id" v-for="item in relationships[field.relationship_table_name]" v-text="item.title"></option>
                    </select>
                    <div v-else>
                        <div class="relationship-many" v-for="(elm, index) in fields_instance['$' + menu_item.table_name + '_' + field.relationship_table_name]">
                            <select class="form-control" v-model="elm[field.relationship_table_name]">
                                <option :value="item.id" v-for="item in relationships[field.relationship_table_name]" v-text="item.title"></option>
                            </select>
                            <div class="btn btn-danger" v-on:click="remove_relationship_field(field, index)">Delete</div>
                        </div>
                        <div class="btn btn-primary" v-on:click="add_relationship_field(field)">Add</div>
                    </div>
                </div>
                <div v-else-if="field.type == 'photo'">
                    <input class="form-control" type="text" :id="field.db_title" v-model="fields_instance[field.db_title]" v-on:change="errors[field.db_title] = ''">
                    <div class="photo-preview-wrapper">
                        <img :src="fields_instance[field.db_title]" alt="" class="photo-preview-img">
                        <div class="btn btn-primary" v-on:click="add_photo(field.db_title)">Add photo</div>
                    </div>
                </div>
                <div v-else-if="field.type == 'file'">
                    <input class="form-control" type="text" :id="field.db_title" v-model="fields_instance[field.db_title]" v-on:change="errors[field.db_title] = ''">
                    <div class="btn btn-primary add-file-btn" v-on:click="add_file(field.db_title)">Add file</div>
                </div>
                <div v-else-if="field.type == 'gallery'">
                    <template v-for="(item, index) in fields_instance[field.db_title]">
                        <input class="form-control gallery-margin-top" type="text" v-model="fields_instance[field.db_title][index]">
                        <div class="photo-preview-wrapper">
                            <img :src="fields_instance[field.db_title][index]" alt="" class="photo-preview-img">
                            <div class="btn btn-danger" v-on:click="remove_gallery(field.db_title, index)">Delete photo</div>
                        </div>
                    </template>
                    <div class="btn btn-primary gallery-margin-top" v-on:click="add_gallery(field.db_title)">Add photos</div>
                </div>
                <div v-else-if="field.type == 'translater'">
                    <textarea class="form-control translate-field" v-model="fields_instance[field.db_title][k]" :placeholder="k" v-for="(v, k, i) in fields_instance[field.db_title]"></textarea>
                </div>
                <div v-else-if="field.type == 'number' || field.type == 'money'">
                    <input class="form-control" type="text" v-model="fields_instance[field.db_title]" v-on:change="errors[field.db_title] = ''">
                </div>
                <div class="input-error" v-text="errors[field.db_title]"></div>
            </div>
        </div>
        <div class="row form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-10">
                <button v-if="id == 0" class="btn btn-primary" v-on:click="create_fields_instance()">Create</button>
                <button v-else class="btn btn-primary" v-on:click="create_fields_instance()">Update</button>
            </div>
        </div>
    </div>
</script>

<script>
    var ckeditor_path = '<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}"; ?>/admin/upload-image'
</script>

<link rel="stylesheet" href="/vendor/fastadminpanel/css/spectrum.css" />
<script src="/vendor/fastadminpanel/js/spectrum.js"></script>

<link rel="stylesheet" href="/vendor/fastadminpanel/css/jquery.ui.css" />
<script src="/vendor/fastadminpanel/js/jquery.ui.js"></script>

<script src="/vendor/fastadminpanel/js/ckeditor-MyCustomUploadAdapterPlugin.js"></script>
<script src="/vendor/fastadminpanel/js/ckeditor.js"></script>
<script src="/vendor/fastadminpanel/js/ckeditor-vue.js"></script>
<script src="/vendor/fastadminpanel/js/components/edit.js"></script>