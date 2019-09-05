<script type="text/x-template" id="template-menu">
    <div class="table-edit">
        <div class="col-sm-10 offset-sm-2">
            <h1>Create or edit CRUD menu item</h1>
        </div>
        <div class="row form-group">
            <label class="col-sm-2 control-label">Menu item</label>
            <div class="col-sm-10">
                <select v-on:change="set_menu_item" class="form-control">
                    <option :value="-1">New</option>
                    <option :value="index" v-for="(item, index) in menu" v-text="item.title"></option>
                </select>
            </div>
        </div>
        <div class="row form-group">
            <label class="col-sm-2 control-label">CRUD name</label>
            <div class="col-sm-10">
                <input v-model="menu_item_edit.table_name" class="form-control" placeholder="ex. books or products (used to generate DB table)" type="text" :disabled="action != 'create'">
            </div>
        </div>
        <div class="row form-group">
            <label class="col-sm-2 control-label">CRUD title</label>
            <div class="col-sm-10">
                <input v-model="menu_item_edit.title" class="form-control" placeholder="Menu title (used for menu item)" type="text">
            </div>
        </div>
        <div class="row form-group disabled">
            <label class="col-sm-2 control-label">Soft delete?</label>
            <div class="col-sm-10">
                <select v-model="menu_item_edit.is_soft_delete" class="form-control">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>
        </div>
        <div class="row form-group">
            <label class="col-sm-2 control-label">Is dev</label>
            <div class="col-sm-10">
                <select v-model="menu_item_edit.is_dev" class="form-control">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>
        </div>
        <div class="row form-group">
            <label class="col-sm-2 control-label">Multilanguage</label>
            <div class="col-sm-10">
                <select v-model="menu_item_edit.multilanguage" class="form-control">
                    <option :value="0">No</option>
                    <option :value="1">Yes</option>
                </select>
            </div>
        </div>
        <div class="row form-group">
            <label class="col-sm-2 control-label">Sort</label>
            <div class="col-sm-10">
                <input v-model="menu_item_edit.sort" class="form-control" placeholder="0" type="text">
            </div>
        </div>
        <hr>
        <h3>Edit fields</h3>
        <table class="table table-editfields">
            <tr>
                <td style="width: 96px;">Is visible?</td>
                <td>Lang</td>
                <td>Show in list</td>
                <td>Field type</td>
                <td>Field DB name</td>
                <td>Field visual name</td>
                <td></td>
                <td></td>
            </tr>
            <tr v-for="(field, index) in menu_item_edit.fields">
                <td>
                    <input v-model="field.is_visible" type="checkbox" class="show-checked">
                </td>
                <td>
                    <select v-model="field.lang" class="form-control type">
                        <option value="1">Separate</option>
                        <option value="0">Common</option>
                    </select>
                </td>
                <td>
                    <select v-model="field.show_in_list" class="form-control type">
                        <option value="no">No</option>
                        <option value="yes">Yes</option>
                        <option value="editable">Editable</option>
                    </select>
                </td>
                <td>
                    <select v-model="field.type" class="form-control type">
                        <option value="text">Text</option>
                        <option value="textarea">Long text</option>
                        <option value="ckeditor">Ckeditor</option>
                        <option value="checkbox">Checkbox</option>
                        <option value="color">Color picker</option>
                        <option value="date">Date picker</option>
                        <option value="datetime">Date and time picker</option>
                        <option value="relationship">Relationship</option>
                        <option value="file">File</option>
                        <option value="photo">Photo</option>
                        <option value="gallery">Gallery</option>
                        <option value="password">Password (hashed)</option>
                        <option value="money">Money</option>
                        <option value="number">Number</option>
                        <option value="enum">Select (ENUM)</option>
                        <option value="repeat">Repeat</option>
                    </select>
                </td>
                <td>
                    <input v-if="field.type != 'relationship'" v-model="field.db_title" type="text" class="form-control title" placeholder="Field DB name">
                    <div v-else>
                        <select v-model="field.relationship_count" class="form-control type">
                            <option value="single">Single</option>
                            <option value="many">Many</option>
                        </select>
                        <select v-model="field.relationship_table_name" class="form-control type">
                            <option :value="item.table_name" v-for="(item, index) in menu" v-text="item.title"></option>
                        </select>
                        <div v-if="field.relationship_table_name">
                            <select v-model="field.relationship_view_field" class="form-control type">
                                <option :value="item.db_title" v-for="(item, index) in get_fields_by_table_name(field.relationship_table_name)" v-text="item.title"></option>
                            </select>
                        </div>
                    </div>
                </td>
                <td>
                    <input v-model="field.title" type="text" class="form-control title" placeholder="Field visual name">
                </td>
                <td>
                    <select v-model="field.required" class="form-control type">
                        <option value="optional">Optional</option>
                        <option value="required">Required</option>
                        <option value="required_unique">Required unique</option>
                    </select>
                </td>
                <td>
                    <div v-on:click="remove_menu_item(index)" class="rem btn btn-danger">-</div>
                </td>
            </tr>
        </table>
        <div class="form-group">
            <div class="col-md-12">
                <button v-on:click="add_menu_item()" type="button" id="addField" class="btn btn-success"><span class="btn-plus">+</span> Add one more field</button>
            </div>
        </div>
        <hr>
        <div class="form-group">
            <div class="col-md-12">
                <button v-if="action == 'create'" v-on:click="create_crud()" class="btn btn-primary">Create CRUD</button>
                <div v-else class="sides">
                    <button v-on:click="update_crud()" class="btn btn-primary">Update CRUD</button>
                    <button v-on:click="remove_crud()" class="btn btn-danger">Remove CRUD</button>
                </div>
            </div>
        </div>
    </div>
</script>
    
<script src="/vendor/fastadminpanel/js/components/menu.js"></script>