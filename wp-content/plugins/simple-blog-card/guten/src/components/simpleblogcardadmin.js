import './simpleblogcardadmin.css';
import { __ } from '@wordpress/i18n';
import apiFetch from '@wordpress/api-fetch';
import {
	Button,
	ColorPalette,
	RadioControl,
	RangeControl,
	SelectControl,
	ToggleControl,
	Notice
} from '@wordpress/components';
import {
	useState,
	useEffect
} from '@wordpress/element';
import Credit from './credit';

const SimpleBlogCardAdmin = () => {

	const simpleblogcard_options = JSON.parse( simple_blog_card_settings_script_data.options );

	const simpleblogcard_options_dessize = simpleblogcard_options.dessize;
	const [ desSize, updatedesSize ] = useState( simpleblogcard_options_dessize );

	const simpleblogcard_options_imgsize = simpleblogcard_options.imgsize;
	const [ imgSize, updateimgSize ] = useState( simpleblogcard_options_imgsize );

	const simpleblogcard_options_img_pos = simpleblogcard_options.img_pos;
	const [ imgPos, updateimgPos ] = useState( simpleblogcard_options_img_pos );

	const simpleblogcard_options_color = simpleblogcard_options.color;
	const [ coLor, updatecoLor ] = useState( simpleblogcard_options_color );
	
	const simpleblogcard_options_color_width = simpleblogcard_options.color_width;
	const [ colorWidth, updatecolorWidth ] = useState( simpleblogcard_options_color_width );

	const simpleblogcard_options_t_line_height= simpleblogcard_options.t_line_height;
	const [ tlineHeight, updatetlineHeight ] = useState( simpleblogcard_options_t_line_height );

	const simpleblogcard_options_d_line_height= simpleblogcard_options.d_line_height;
	const [ dlineHeight, updatedlineHeight ] = useState( simpleblogcard_options_d_line_height );

	const simpleblogcard_options_target_blank = simpleblogcard_options.target_blank;
	const [ targetBlank, updatetargetBlank ] = useState( simpleblogcard_options_target_blank );

	const simpleblogcard_options_encoding = simpleblogcard_options.encoding;
	const [ enCoding, updateenCoding ] = useState( simpleblogcard_options_encoding );

	const simpleblogcard_timeout = simple_blog_card_settings_script_data.timeout;
	const [ timeOut, updatetimeOut ] = useState( parseInt( simpleblogcard_timeout ) );

	const simpleblogcard_template = simple_blog_card_settings_script_data.template;
	const [ temPlate, updatetemPlate ] = useState( simpleblogcard_template );

	const simpleblogcard_template_label_value = JSON.parse( simple_blog_card_settings_script_data.template_label_value );

	const simpleblogcard_template_overviews = JSON.parse( simple_blog_card_settings_script_data.template_overviews );

	const [ cacheSubmitdelete, updatecacheSubmitdelete ] = useState( false );
	const [ cacheDeletemessage, updatecacheDeletemessage ] = useState( '' );

	useEffect( () => {
		apiFetch( {
			path: 'rf/simpleblogcard_set_api/token',
			method: 'POST',
			data: {
				dessize: desSize,
				imgsize: imgSize,
				img_pos: imgPos,
				color: coLor,
				color_width: colorWidth,
				t_line_height: tlineHeight,
				d_line_height: dlineHeight,
				target_blank: targetBlank,
				encoding: enCoding,
				timeout: timeOut,
				template: temPlate,
				cache_delete: cacheSubmitdelete,
			}
		} ).then( ( response ) => {
			//console.log( response );
			if ( cacheSubmitdelete ) {
				updatecacheDeletemessage( __( 'Removed the cache.', 'simple-blog-card' ) );
			}
			updatecacheSubmitdelete( false );
		} );
	}, [ desSize, imgSize, imgPos, coLor, colorWidth, tlineHeight, dlineHeight, targetBlank, enCoding, timeOut, temPlate, cacheSubmitdelete ] );

	const items_dessize = [];
	if ( typeof desSize !== 'undefined' ) {
		items_dessize.push(
			<RangeControl
				__nextHasNoMarginBottom
				max = { 300 }
				min = { 0 }
				value = { desSize }
				onChange = { ( value ) => updatedesSize( value ) }
			/>
		);
	}
	//console.log( desSize );

	const items_imgsize = [];
	if ( typeof imgSize !== 'undefined' ) {
		items_imgsize.push(
			<RangeControl
				__nextHasNoMarginBottom
				max = { 300 }
				min = { 0 }
				value={ imgSize }
				onChange={ ( value ) => updateimgSize( value ) }
			/>
		);
	}
	//console.log( imgSize );

	const items_imgpos = [];
	if ( typeof imgPos !== 'undefined' ) {
		items_imgpos.push(
			<RadioControl
				selected = { imgPos }
				options = { [
					{ label: __( 'Left', 'simple-blog-card' ), value: 'left' },
					{ label: __( 'Right', 'simple-blog-card' ), value: 'right' },
				] }
				onChange = { ( value ) => updateimgPos( value ) }
			/>
		);
	}
	//console.log( imgPos );

	const items_color = [];
	const colors = [
		{ name: __( 'Navy', 'simple-blog-card' ), color: '#000080' },
		{ name: __( 'Green', 'simple-blog-card' ), color: '#008000' },
		{ name: __( 'Yellow', 'simple-blog-card' ), color: '#ffff00' },
		{ name: __( 'Red', 'simple-blog-card' ), color: '#ff0000' },
		{ name: __( 'Brown', 'simple-blog-card' ), color: '#8f6446' },
		{ name: __( 'Black', 'simple-blog-card' ), color: '#000000' },
		{ name: __( 'White', 'simple-blog-card' ), color: '#ffffff' },
	];
	if ( typeof coLor !== 'undefined' ) {
		items_color.push(
			<ColorPalette
				clearable = { false }
				colors = { colors }
				value = { coLor }
				onChange = { ( value ) => updatecoLor( value ) }
			/>
		);
	}
	//console.log( coLor );

	const items_colorwidth = [];
	if ( typeof colorWidth !== 'undefined' ) {
		items_colorwidth.push(
			<RangeControl
				__nextHasNoMarginBottom
				max = { 15 }
				min = { 0 }
				value={ colorWidth }
				onChange={ ( value ) => updatecolorWidth( value ) }
			/>
		);
	}
	//console.log( colorWidth );

	const items_t_line_height = [];
	if ( typeof tlineHeight !== 'undefined' ) {
		items_t_line_height.push(
			<RangeControl
				__nextHasNoMarginBottom
				max = { 300 }
				min = { 10 }
				value={ tlineHeight }
				onChange={ ( value ) => updatetlineHeight( value ) }
			/>
		);
	}
	//console.log( tlineHeight );

	const items_d_line_height = [];
	if ( typeof dlineHeight !== 'undefined' ) {
		items_d_line_height.push(
			<RangeControl
				__nextHasNoMarginBottom
				max = { 300 }
				min = { 10 }
				value={ dlineHeight }
				onChange={ ( value ) => updatedlineHeight( value ) }
			/>
		);
	}
	//console.log( dlineHeight );

	const items_target_blank = [];
	if ( typeof targetBlank !== 'undefined' ) {
		items_target_blank.push(
			<ToggleControl
				__nextHasNoMarginBottom
				checked={ targetBlank }
				onChange={ ( value ) => updatetargetBlank( value ) }
			/>
		);
	}
	//console.log( targetBlank );

	const items_encoding = [];
	if ( typeof enCoding !== 'undefined' ) {
		items_encoding.push(
			<SelectControl
				value = { enCoding }
				options={ [
					{ label: 'UTF-8', value: 'UTF-8' },
					{ label: 'ASCII', value: 'ASCII' },
					{ label: 'EUC-JP', value: 'EUC-JP' },
					{ label: 'SJIS', value: 'SJIS' },
					{ label: 'eucJP-win', value: 'eucJP-win' },
					{ label: 'SJIS-win', value: 'SJIS-win' },
					{ label: 'JIS', value: 'JIS' },
					{ label: 'ISO-2022-JP', value: 'ISO-2022-JP' },
				] }
				onChange={  ( value ) => updateenCoding( value ) }
				__nextHasNoMarginBottom
			/>
		);
	}
	//console.log( enCoding );

	const items_timeout = [];
	if ( typeof timeOut !== 'undefined' ) {
		items_timeout.push(
			<RangeControl
				__nextHasNoMarginBottom
				max = { 30 }
				min = { 3 }
				value={ timeOut }
				onChange={ ( value ) => updatetimeOut( value ) }
			/>
		);
	}
	//console.log( timeOut );

	const items_templates = [];
	if ( typeof temPlate !== 'undefined' ) {
		items_templates.push(
			<SelectControl
				value = { temPlate }
				options={ simpleblogcard_template_label_value }
				onChange={  ( value ) => updatetemPlate( value ) }
				__nextHasNoMarginBottom
			/>
		);
	}
	//console.log( temPlate );

	const items_template_overview = [];
	if ( simpleblogcard_template_overviews.hasOwnProperty( temPlate ) ) {
		items_template_overview.push(
			<ul>
				<li>{ __( 'Description', 'simple-blog-card' ) } : { simpleblogcard_template_overviews[ temPlate ]['description'] }</li>
				<li>{ __( 'Version', 'simple-blog-card' ) } : { simpleblogcard_template_overviews[ temPlate ]['version'] }</li>
				<li>{ __( 'Author', 'simple-blog-card' ) } : <a className="aStyle" href={ simpleblogcard_template_overviews[ temPlate ]['author_link'] } target="_blank" rel="noopener">{ simpleblogcard_template_overviews[ temPlate ]['author'] }</a></li>
			</ul>
		);
	}
	//console.log( simpleblogcard_template_overviews[ temPlate ] );

	const onclick_cache_delete = () => {
		updatecacheSubmitdelete( true );
	};
	const items_cache_submit_delete = [];
	items_cache_submit_delete.push(
		<p>
			<Button
				className = { 'button button-primary' }
				onClick = { onclick_cache_delete }
			>
			{ __( 'Remove Cache', 'simple-blog-card' ) }
			</Button>
		</p>
	);
	//console.log( cacheSubmitdelete );

	const items_deletes_notice = [];
	if ( cacheDeletemessage ) {
		items_deletes_notice.push(
			<Notice
				status = "success"
				onRemove = { () =>
					{
						updatecacheDeletemessage( '' );
					}
				}
			>
			{ cacheDeletemessage }
			</Notice>
		);
	}

	return (
		<>
			<h2>Simple Blog Card</h2>
			<Credit />
			<hr />
			<div><strong>{ __( 'Block', 'simple-blog-card' ) }</strong></div>
			<div className="outer-paragraph">
				<li>{ __( 'You can search for blocks using the following five words.', 'simple-blog-card' ) }</li>
				<div className="inner-paragraph">
					<div>
					<code>{ __( 'blogcard', 'simple-blog-card' ) }</code>
					<code>{ __( 'card', 'simple-blog-card' ) }</code>
					<code>{ __( 'external link', 'simple-blog-card' ) }</code>
					<code>{ __( 'internal link', 'simple-blog-card' ) }</code>
					<code>{ __( 'linkcard', 'simple-blog-card' ) }</code>
					</div>
					<figure>
					<img src={ simple_blog_card_settings_script_data.img_block_search } />
					</figure>
				</div>
			</div>
			<hr />
			<div><strong>{ __( 'Shortcode', 'simple-blog-card' ) }</strong></div>
			<div className="outer-paragraph">
				<li>
				<code>[simpleblogcard url="http://***.*/"]</code>
				</li>
			</div>
			<hr />
			<div><strong>{ __( 'Default attribute values', 'simple-blog-card' ) }</strong></div>
			<table border="1" cellspacing="0" cellpadding="5" bordercolor="#000000">
			<tr>
			<th align="center"><strong>{ __( 'Attribute', 'simple-blog-card' ) }</strong></th>
			<th align="center"><strong>{ __( 'Description', 'simple-blog-card' ) }</strong></th>
			<th align="center" width="250px"><strong>{ __( 'Default value', 'simple-blog-card' ) }</strong></th>
			</tr>
			<tr>
			<td align="center"><code>url</code></td>
			<td align="right"><strong>URL:</strong></td>
			<td></td>
			</tr>
			<tr>
			<td align="center"><code>dessize</code></td>
			<td align="right"><strong>{ __( 'Description length', 'simple-blog-card' ) }:</strong></td>
			<td>{ items_dessize }</td>
			</tr>
			<tr>
			<td align="center"><code>imgsize</code></td>
			<td align="right"><strong>{ __( 'Image sizes', 'simple-blog-card' ) }:</strong></td>
			<td>{ items_imgsize }</td>
			</tr>
			<tr>
			<td align="center"><code>img_pos</code></td>
			<td align="right"><strong>{ __( 'Image position', 'simple-blog-card' ) }:</strong></td>
			<td>{ items_imgpos }</td>
			</tr>
			<tr>
			<td align="center"><code>color</code></td>
			<td align="right"><strong>{ __( 'Border color', 'simple-blog-card' ) }:</strong></td>
			<td>{ items_color }</td>
			</tr>
			<tr>
			<td align="center"><code>color_width</code></td>
			<td align="right"><strong>{ __( 'Border color width', 'simple-blog-card' ) }:</strong></td>
			<td>{ items_colorwidth }</td>
			</tr>
			<tr>
			<td align="center"><code>title</code></td>
			<td align="right"><strong>{ __( 'Title', 'simple-blog-card' ) }:</strong></td>
			<td></td>
			</tr>
			<tr>
			<td align="center"><code>t_line_height</code></td>
			<td align="right"><strong>{ __( 'Title line height', 'simple-blog-card' ) }:</strong></td>
			<td>{ items_t_line_height }</td>
			</tr>
			<tr>
			<td align="center"><code>description</code></td>
			<td align="right"><strong>{ __( 'Description', 'simple-blog-card' ) }:</strong></td>
			<td></td>
			</tr>
			<tr>
			<td align="center"><code>d_line_height</code></td>
			<td align="right"><strong>{ __( 'Description line height', 'simple-blog-card' ) }:</strong></td>
			<td>{ items_d_line_height }</td>
			</tr>
			<tr>
			<td align="center"><code>target_blank</code></td>
			<td align="right"><strong>{ __( 'Open in new tab', 'simple-blog-card' ) }:</strong></td>
			<td>{ items_target_blank }</td>
			</tr>
			<tr>
			<td align="center"><code>encoding</code></td>
			<td align="right"><strong>{ __( 'Character encoding', 'simple-blog-card' ) }:</strong></td>
			<td>{ items_encoding }</td>
			</tr>
			</table>
			<hr />
			<div><strong>{ __( 'Time out', 'simple-blog-card' ) }</strong></div>
			<div className="outer-paragraph">
				<li>{ __( 'The limit on the number of seconds a URL can fetch HTML when there is no cache.', 'simple-blog-card' ) }</li>
				<div className="inner-paragraph">
					<li>{ __( 'On the management screen, any value from 3 to 30 seconds, default 10 seconds.', 'simple-blog-card' ) }</li>
					<li>{ __( 'Outside the management screen, fixed value to 3 seconds.', 'simple-blog-card' ) }</li>
				</div>
				<div className="timeout-width">
					{ items_timeout }
				</div>
			</div>
			<hr />
			<div><strong>{ __( 'Cache', 'simple-blog-card' ) }</strong></div>
			<div className="outer-paragraph">
				<li>{ __( 'Cache is valid for 2 weeks.', 'simple-blog-card' ) }</li>
				{ items_cache_submit_delete }
				{ items_deletes_notice }
				<li>{ __( 'Can delete and regenerate the cache with the following WP-CLI command. It would be beneficial to register it with the server\'s cron.', 'simple-blog-card' ) }</li>
				<div><strong>WP-CLI</strong></div>
				<div><code>wp simpleblogcard_refresh</code></div>
			</div>
			<hr />
			<div><strong>{ __( 'Select template and CSS', 'simple-blog-card' ) }</strong></div>
			<div className="outer-paragraph">
			{ items_templates }
			</div>
			<div className="outer-paragraph">
			<div><strong>{ __( 'Overview of the selected template', 'simple-blog-card' ) }</strong></div>
				{ items_template_overview }
				<p className="description">{ __( 'If you create a stylish template, please contact me. If i incorporate it into this plugin, i will consider you a contributor to the plugin.', 'simple-blog-card' ) }</p>
				<div>{ __( 'Template files allow for flexible customization.', 'simple-blog-card' ) } -> <a className="aStyle" href="https://github.com/katsushi-kawamori/Simple-Blog-Card-Templates" target="_blank" rel="noopener noreferrer">{ __( 'Customize', 'simple-blog-card' ) }</a></div>
			</div>
		</>
	);

};

export default SimpleBlogCardAdmin;
