<script type="text/x-template" id="template-index">

    <div class="index">
        <div v-show="!is_edit" class="btn btn-info" v-on:click="add_new_row">Add new</div>
        <div v-show="!is_edit" class="portlet box green">
            <div class="portlet-title">
                <div class="caption">List</div>
            </div>
            <div class="portlet-body">
                <div id="datatable_wrapper">
                    <div id="datatable_filter">
                        <div class="datatables-sort">
                            <label>Sort by 
                                <select v-on:change="get_fields_instances" v-model="order">
                                    <option v-for="field in menu_item.fields" v-if="field.show_in_list != 'no'" :value="field.db_title" v-text="field.title"></option>
                                </select>
                            </label>
                        </div>
                        <label>
                            Search:<input type="search" v-model="search">
                        </label>
                    </div>
                    <table class="table table-striped table-hover table-responsive datatable dataTable no-footer">
                        <thead>
                            <tr>
                                <th class="sorting_asc">
                                    <input type="checkbox" v-on:click="set_marked($event.target.checked)">
                                </th>
                                <th class="sorting" v-for="field in menu_item.fields" v-if="field.show_in_list != 'no'" v-text="field.title"></th>
                                <th class="sorting">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="instance in instances">
                                <td class="td-content">
                                    <input type="checkbox" v-on:change="instance.marked = $event.target.checked" :checked="instance.marked">
                                </td>
                                <td class="td-content" v-for="field in menu_item.fields" v-if="field.show_in_list != 'no'" v-text="instance[field.db_title]"></td>
                                <td class="td-actions">
                                    <div class="btn btn-xs btn-info" v-on:click="edit_row(instance.id, instance.language_id)">Edit</div>
                                    <div class="btn btn-xs btn-danger td-actions-delete" v-on:click="remove_row(instance.id)">Delete</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="index-pagination">
                        <div class="index-pagination-show">Showing <span v-text="(offset + 1)"></span> to <span v-text="(offset + instances.length)"></span> <span v-if="count > 0">of <span v-text="count"></span> entries</span></div>
                        <div class="index-pagination-btns">
                            <div class="index-pagination-prev" onselectstart="return false" :class="{'disabled': curr_page == 1, 'active': curr_page != 1 && pages_count > 1}" v-on:click="prev_page()">Previous</div>
                            <div class="index-pagination-numbers">
                                <div class="index-pagination-number" v-if="pages_count < 5 || (i == 1 || i == pages_count || i == curr_page)" v-on:click="curr_page = i" :class="{'active': i == curr_page}" v-for="i in pages_count" v-text="i"></div>
                                <div class="index-pagination-number" v-else-if="i == curr_page - 1 || i == curr_page + 1">...</div>
                            </div>
                            <div class="index-pagination-next" onselectstart="return false" :class="{'disabled': curr_page == pages_count, 'active': curr_page != pages_count && pages_count > 1}" v-on:click="next_page()">Next</div>
                        </div>
                    </div>
                </div>
                <div class="mass-delete-col">
                    <button class="btn btn-danger" v-on:click="delete_checked">
                        Delete checked
                    </button>
                </div>
            </div>
        </div>
        
        <template-edit v-if="is_edit" :menu_item="menu_item" :id="edit_id" :language_id="edit_language_id" :key="edit_unique_id" v-on:back="set_back"></template-edit>
    </div>
</script>
    
<script src="/vendor/fastadminpanel/js/components/index.js"></script>