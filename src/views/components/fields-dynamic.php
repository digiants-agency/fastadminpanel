<script type="text/x-template" id="template-fields-dynamic">
	<div class="row form-group">
		<label class="col-sm-2 control-label" v-text="field.title"></label>
		<div class="col-sm-10">
			<div v-if="field.type == 'text'">
				<input class="form-control" type="text" v-model="fields_instance[field.db_title]" v-on:change="error = ''" v-on:input="change_text" maxlength="191">
			</div>
			<div v-else-if="field.type == 'textarea'">
				<textarea v-on:input="change_textarea" :rows="textarea_height" class="form-control" v-model="fields_instance[field.db_title]"></textarea>
			</div>
			<div v-else-if="field.type == 'ckeditor'">
				<ckeditor :config="editorConfig" :editor="editor" class="form-control" v-model="fields_instance[field.db_title]"></ckeditor>
			</div>
			<div v-else-if="field.type == 'checkbox'">
				<input class="form-control form-control-checkbox" type="checkbox" v-model="fields_instance[field.db_title]">
			</div>
			<div v-else-if="field.type == 'color'">
				<input class="form-control colorpicker" type="text" :id="field.db_title" v-on:change="error = ''">
			</div>
			<div v-else-if="field.type == 'date'">
				<input class="form-control datepicker" data-init="0" type="text" :id="field.db_title" v-on:change="error = ''">
			</div>
			<div v-else-if="field.type == 'enum'">
				<select class="form-control" v-model="fields_instance[field.db_title]">
					<option :value="field.enum[index]" v-for="(item, index) in field.enum" v-text="field.enum[index]"></option>
				</select>
			</div>
			<div v-else-if="field.type == 'relationship'">
				<select v-if="field.relationship_count == 'single'" class="form-control" v-model="fields_instance['id_' + field.relationship_table_name]">
					<option :value="item.id" v-for="item in relationships[field.relationship_table_name]" v-text="item.title"></option>
				</select>
				<div v-else-if="field.relationship_count == 'many'">
					<div class="relationship-many" v-for="(elm, index) in fields_instance['$' + table_name + '_' + field.relationship_table_name]">
						<select class="form-control" v-model="elm[field.relationship_table_name]">
							<option :value="item.id" v-for="item in relationships[field.relationship_table_name]" v-text="item.title"></option>
						</select>
						<div class="btn btn-danger" v-on:click="remove_relationship_field(field, index)">Delete</div>
					</div>
					<div class="btn btn-primary" v-on:click="add_relationship_field(field)">Add</div>
				</div>
			</div>
			<div v-else-if="field.type == 'photo'">
				<input class="form-control" type="text" :id="field.db_title" v-model="fields_instance[field.db_title]" v-on:change="error = ''">
				<div class="photo-preview-wrapper">
					<img :src="fields_instance[field.db_title]" alt="" class="photo-preview-img">
					<div class="btn btn-primary" v-on:click="add_photo(field.db_title)">Add photo</div>
				</div>
			</div>
			<div v-else-if="field.type == 'file'">
				<input class="form-control" type="text" :id="field.db_title" v-model="fields_instance[field.db_title]" v-on:change="error = ''">
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
				<div v-for="(value, key, j) in fields_instance[field.db_title]">
					<h2 v-text="key + ':'" style="margin-bottom: 15px;"></h2>
					<template v-for="(v, k, i) in fields_instance[field.db_title][key]">
						<div v-text="k + ':'"></div>
						<textarea class="form-control translate-field" v-model="fields_instance[field.db_title][key][k]"></textarea>
					</template>
				</div>
			</div>
			<div v-else-if="field.type == 'number' || field.type == 'money'">
				<input class="form-control" type="text" v-model="fields_instance[field.db_title]" v-on:change="error = ''">
			</div>
			<div class="input-error" v-text="error"></div>
		</div>
	</div>
</script>
<script>
	Vue.component('template-fields-dynamic',{
		template: '#template-fields-dynamic',
		props:['field', 'fields_instance', 'relationships', 'index', 'table_name'],
		components: {
			// Use the <ckeditor> component in this view.
			ckeditor: CKEditor.component
		},
		data: function () {
			return {
				error: '',
				editor: ClassicEditor,
				editorConfig: {
					extraPlugins: [ MyCustomUploadAdapterPlugin ],
				},
				textarea_height: 1,
			}
		},
		methods: {
			check: function(){

				let instance = this.fields_instance
				let field = this.field

				if (instance[field.db_title] == undefined) {
					if (field.type == 'relationship' && field.relationship_count == 'single' && instance['id_' + field.relationship_table_name] == undefined)
						instance['id_' + field.relationship_table_name] = 0
					else if (field.type != 'relationship') {
						instance[field.db_title] = this.get_standart_val(field.type)
					}
				}
				
				if (field.required != 'optional' && !instance[field.db_title]) {
					this.error = 'This field is required'
				} else if (field.required == 'required_once') {
					// TODO
				}
				
					
				if (field.type == 'text') {
					if (instance[field.db_title].length > 191)
						this.error = 'More than maxlength (191 symbols)'
				} else if (field.type == 'number' || field.type == 'money') {
					if (!$.isNumeric(instance[field.db_title]))
						this.error = 'Field must be numeric. Use "." instead of ","'
				}

				if (this.error == '')
					return true
				return false
			},
			get_standart_val: function(type){
				// TODO: enum, relationship
				if (type == 'checkbox' || type == 'money' || type == 'number') return 0
				if (type == 'color') return '#000000'
				if (type == 'date') return '2000-00-00'
				if (type == 'datetime') return '2000-00-00 12:00:00'
				if (type == 'gallery') return []
				if (type == 'translater') return {}
				if (type == 'repeat') return ''
				return ''
			},
			change_textarea: function(e){

				let count = (this.fields_instance[this.field.db_title].match(/\n/g) || []).length
				
				this.textarea_height = count + 1

				if (this.field.db_title == 'title') {
					this.$root.$emit('title_changed', e.target.value)
				}
			},
			change_text: function(e){

				if (this.field.db_title == 'title') {
					this.$root.$emit('title_changed', e.target.value)
				}
			},
			add_photo: function(id){

				window.open('/laravel-filemanager?type=image', 'FileManager', 'width=900,height=600');
				window.SetUrl = (items)=>{

					for (var i = 0; i < items.length; i++) {

						var url = items[i].url.replace(document.location.origin, '')

						this.fields_instance[id] = url
						this.$forceUpdate()

						break;
					}
				};
			},
			add_file: function(id){

				window.open('/laravel-filemanager?type=file', 'FileManager', 'width=900,height=600');
				window.SetUrl = (items)=>{

					for (var i = 0; i < items.length; i++) {

						var url = items[i].url.replace(document.location.origin, '')

						this.fields_instance[id] = url
						this.$forceUpdate()

						break;
					}
				};
			},
			add_gallery: function(id){
				window.open('/laravel-filemanager?type=image', 'FileManager', 'width=900,height=600');
				window.SetUrl = (items)=>{

					if (this.fields_instance[id])
						var arr = this.fields_instance[id]
					else  var arr = []
					
					for (var i = 0; i < items.length; i++) {

						var url = items[i].url.replace(document.location.origin, '')
						arr.push(url)
					}
					this.fields_instance[id] = arr
					this.$forceUpdate()
				};
			},
			remove_gallery: function(id, index){
				this.fields_instance[id].splice(index, 1)
				this.$forceUpdate()
			},
			add_relationship_field: function(field){

				var relationships = this.relationships[field.relationship_table_name]

				var add = {}

				if (relationships.length > 0)
					add[field.relationship_table_name] = relationships[0].id
				else add[field.relationship_table_name] = 0

				this.fields_instance['$' + this.table_name + '_' + field.relationship_table_name].push(add)
				this.$forceUpdate()
			},
			remove_relationship_field: function(field, id){
				
				this.fields_instance['$' + this.table_name + '_' + field.relationship_table_name].splice(id, 1)
				this.$forceUpdate()
			},
			slugify: function(s, opt) {
				s = String(s);
				opt = Object(opt);
				
				var defaults = {
					'delimiter': '-',
					'limit': undefined,
					'lowercase': true,
					'replacements': {},
					'transliterate': (typeof(XRegExp) === 'undefined') ? true : false
				};
				
				// Merge options
				for (var k in defaults) {
					if (!opt.hasOwnProperty(k)) {
						opt[k] = defaults[k];
					}
				}
				
				var char_map = {
					// Latin
					'À': 'A', 'Á': 'A', 'Â': 'A', 'Ã': 'A', 'Ä': 'A', 'Å': 'A', 'Æ': 'AE', 'Ç': 'C', 
					'È': 'E', 'É': 'E', 'Ê': 'E', 'Ë': 'E', 'Ì': 'I', 'Í': 'I', 'Î': 'I', 'Ï': 'I', 
					'Ð': 'D', 'Ñ': 'N', 'Ò': 'O', 'Ó': 'O', 'Ô': 'O', 'Õ': 'O', 'Ö': 'O', 'Ő': 'O', 
					'Ø': 'O', 'Ù': 'U', 'Ú': 'U', 'Û': 'U', 'Ü': 'U', 'Ű': 'U', 'Ý': 'Y', 'Þ': 'TH', 
					'ß': 'ss', 
					'à': 'a', 'á': 'a', 'â': 'a', 'ã': 'a', 'ä': 'a', 'å': 'a', 'æ': 'ae', 'ç': 'c', 
					'è': 'e', 'é': 'e', 'ê': 'e', 'ë': 'e', 'ì': 'i', 'í': 'i', 'î': 'i', 'ï': 'i', 
					'ð': 'd', 'ñ': 'n', 'ò': 'o', 'ó': 'o', 'ô': 'o', 'õ': 'o', 'ö': 'o', 'ő': 'o', 
					'ø': 'o', 'ù': 'u', 'ú': 'u', 'û': 'u', 'ü': 'u', 'ű': 'u', 'ý': 'y', 'þ': 'th', 
					'ÿ': 'y',

					// Latin symbols
					'©': '(c)',

					// Greek
					'Α': 'A', 'Β': 'B', 'Γ': 'G', 'Δ': 'D', 'Ε': 'E', 'Ζ': 'Z', 'Η': 'H', 'Θ': '8',
					'Ι': 'I', 'Κ': 'K', 'Λ': 'L', 'Μ': 'M', 'Ν': 'N', 'Ξ': '3', 'Ο': 'O', 'Π': 'P',
					'Ρ': 'R', 'Σ': 'S', 'Τ': 'T', 'Υ': 'Y', 'Φ': 'F', 'Χ': 'X', 'Ψ': 'PS', 'Ω': 'W',
					'Ά': 'A', 'Έ': 'E', 'Ί': 'I', 'Ό': 'O', 'Ύ': 'Y', 'Ή': 'H', 'Ώ': 'W', 'Ϊ': 'I',
					'Ϋ': 'Y',
					'α': 'a', 'β': 'b', 'γ': 'g', 'δ': 'd', 'ε': 'e', 'ζ': 'z', 'η': 'h', 'θ': '8',
					'ι': 'i', 'κ': 'k', 'λ': 'l', 'μ': 'm', 'ν': 'n', 'ξ': '3', 'ο': 'o', 'π': 'p',
					'ρ': 'r', 'σ': 's', 'τ': 't', 'υ': 'y', 'φ': 'f', 'χ': 'x', 'ψ': 'ps', 'ω': 'w',
					'ά': 'a', 'έ': 'e', 'ί': 'i', 'ό': 'o', 'ύ': 'y', 'ή': 'h', 'ώ': 'w', 'ς': 's',
					'ϊ': 'i', 'ΰ': 'y', 'ϋ': 'y', 'ΐ': 'i',

					// Turkish
					'Ş': 'S', 'İ': 'I', 'Ç': 'C', 'Ü': 'U', 'Ö': 'O', 'Ğ': 'G',
					'ş': 's', 'ı': 'i', 'ç': 'c', 'ü': 'u', 'ö': 'o', 'ğ': 'g', 

					// Russian
					'А': 'A', 'Б': 'B', 'В': 'V', 'Г': 'G', 'Д': 'D', 'Е': 'E', 'Ё': 'Yo', 'Ж': 'Zh',
					'З': 'Z', 'И': 'I', 'Й': 'J', 'К': 'K', 'Л': 'L', 'М': 'M', 'Н': 'N', 'О': 'O',
					'П': 'P', 'Р': 'R', 'С': 'S', 'Т': 'T', 'У': 'U', 'Ф': 'F', 'Х': 'H', 'Ц': 'C',
					'Ч': 'Ch', 'Ш': 'Sh', 'Щ': 'Sh', 'Ъ': '', 'Ы': 'Y', 'Ь': '', 'Э': 'E', 'Ю': 'Yu',
					'Я': 'Ya',
					'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'yo', 'ж': 'zh',
					'з': 'z', 'и': 'i', 'й': 'j', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o',
					'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'h', 'ц': 'c',
					'ч': 'ch', 'ш': 'sh', 'щ': 'sh', 'ъ': '', 'ы': 'y', 'ь': '', 'э': 'e', 'ю': 'yu',
					'я': 'ya',

					// Ukrainian
					'Є': 'Ye', 'І': 'I', 'Ї': 'Yi', 'Ґ': 'G',
					'є': 'ye', 'і': 'i', 'ї': 'yi', 'ґ': 'g',

					// Czech
					'Č': 'C', 'Ď': 'D', 'Ě': 'E', 'Ň': 'N', 'Ř': 'R', 'Š': 'S', 'Ť': 'T', 'Ů': 'U', 
					'Ž': 'Z', 
					'č': 'c', 'ď': 'd', 'ě': 'e', 'ň': 'n', 'ř': 'r', 'š': 's', 'ť': 't', 'ů': 'u',
					'ž': 'z', 

					// Polish
					'Ą': 'A', 'Ć': 'C', 'Ę': 'e', 'Ł': 'L', 'Ń': 'N', 'Ó': 'o', 'Ś': 'S', 'Ź': 'Z', 
					'Ż': 'Z', 
					'ą': 'a', 'ć': 'c', 'ę': 'e', 'ł': 'l', 'ń': 'n', 'ó': 'o', 'ś': 's', 'ź': 'z',
					'ż': 'z',

					// Latvian
					'Ā': 'A', 'Č': 'C', 'Ē': 'E', 'Ģ': 'G', 'Ī': 'i', 'Ķ': 'k', 'Ļ': 'L', 'Ņ': 'N', 
					'Š': 'S', 'Ū': 'u', 'Ž': 'Z', 
					'ā': 'a', 'č': 'c', 'ē': 'e', 'ģ': 'g', 'ī': 'i', 'ķ': 'k', 'ļ': 'l', 'ņ': 'n',
					'š': 's', 'ū': 'u', 'ž': 'z'
				};
				
				// Make custom replacements
				for (var k in opt.replacements) {
					s = s.replace(RegExp(k, 'g'), opt.replacements[k]);
				}
				
				// Transliterate characters to ASCII
				if (opt.transliterate) {
					for (var k in char_map) {
						s = s.replace(RegExp(k, 'g'), char_map[k]);
					}
				}
				
				// Replace non-alphanumeric characters with our delimiter
				var alnum = (typeof(XRegExp) === 'undefined') ? RegExp('[^a-z0-9]+', 'ig') : XRegExp('[^\\p{L}\\p{N}]+', 'ig');
				s = s.replace(alnum, opt.delimiter);
				
				// Remove duplicate delimiters
				s = s.replace(RegExp('[' + opt.delimiter + ']{2,}', 'g'), opt.delimiter);
				
				// Truncate slug to max. characters
				s = s.substring(0, opt.limit);
				
				// Remove delimiter from ends
				s = s.replace(RegExp('(^' + opt.delimiter + '|' + opt.delimiter + '$)', 'g'), '');
				
				return opt.lowercase ? s.toLowerCase() : s;
			},
		},
		created: function(){
			if (this.field.db_title == 'slug' && !this.$route.params.edit_id) {
				this.$root.$on('title_changed', (title)=>{
					this.fields_instance[this.field.db_title] = this.slugify(title)
					this.$forceUpdate()
				})
			}
		},
		destroyed: function(){
			this.$root.$off('title_changed')
		},
	})
</script>