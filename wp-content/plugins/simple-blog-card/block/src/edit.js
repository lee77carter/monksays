import { __ } from '@wordpress/i18n';
import ServerSideRender from '@wordpress/server-side-render';
import { TextControl, RadioControl, RangeControl, ToggleControl, ColorPalette, SelectControl } from '@wordpress/components';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';

export default function Edit( { attributes, setAttributes } ) {
	const blockProps = useBlockProps();

	return (
		<div { ...blockProps }>
			<ServerSideRender
				block = 'simple-blog-card/simpleblogcard-block'
				attributes = { attributes }
			/>
			<TextControl
				__nextHasNoMarginBottom
				label = 'URL'
				value = { attributes.url }
				onChange = { ( value ) => setAttributes( { url: value } ) }
			/>

			<InspectorControls>
				<TextControl
					__nextHasNoMarginBottom
					label = 'URL'
					value = { attributes.url }
					onChange = { ( value ) => setAttributes( { url: value } ) }
				/>
				<RangeControl
					__nextHasNoMarginBottom
					label = { __( 'Description length', 'simple-blog-card' ) }
					max = { 300 }
					min = { 0 }
					value = { attributes.dessize }
					onChange = { ( value ) => setAttributes( { dessize: value } ) }
				/>
				<RangeControl
					__nextHasNoMarginBottom
					label = { __( 'Image sizes', 'simple-blog-card' ) }
					max = { 200 }
					min = { 0 }
					value = { attributes.imgsize }
					onChange = { ( value ) => setAttributes( { imgsize: value } ) }
				/>
				<RadioControl
					label = { __( 'Image position', 'simple-blog-card' ) }
					selected = { attributes.img_pos }
					onChange = { ( value ) => setAttributes( { img_pos: value } ) }
					options = { [
					{ label: __( 'Left', 'simple-blog-card' ), value: 'left' },
					{ label: __( 'Right', 'simple-blog-card' ), value: 'right' },
					] }
				/>
				{ __( 'Border color', 'simple-blog-card' ) }
				<ColorPalette
					colors={ [
						{ name: __( 'White', 'simple-blog-card' ),  color: '#ffffff' },
						{ name: __( 'Black', 'simple-blog-card' ),  color: '#000000' },
						{ name: __( 'Red', 'simple-blog-card' ),    color: '#ff0000' },
						{ name: __( 'Yellow', 'simple-blog-card' ), color: '#ffff00' },
						{ name: __( 'Blue', 'simple-blog-card' ),   color: '#0000ff' },
					] }
					value = { attributes.color }
					onChange = { ( value ) => setAttributes( { color: value } ) }
				/>
				<RangeControl
					__nextHasNoMarginBottom
					label = { __( 'Border color width', 'simple-blog-card' ) }
					max = { 15 }
					min = { 0 }
					value = { attributes.color_width }
					onChange = { ( value ) => setAttributes( { color_width: value } ) }
				/>
				<TextControl
					__nextHasNoMarginBottom
					label = { __( 'Title', 'simple-blog-card' ) }
					value = { attributes.title }
					onChange = { ( value ) => setAttributes( { title: value } ) }
				/>
				<RangeControl
					__nextHasNoMarginBottom
					label = { __( 'Title line height', 'simple-blog-card' ) }
					max = { 300 }
					min = { 10 }
					value = { attributes.t_line_height }
					onChange = { ( value ) => setAttributes( { t_line_height: value } ) }
				/>
				<TextControl
					__nextHasNoMarginBottom
					label = { __( 'Description', 'simple-blog-card' ) }
					value = { attributes.description }
					onChange = { ( value ) => setAttributes( { description: value } ) }
				/>
				<RangeControl
					__nextHasNoMarginBottom
					label = { __( 'Description line height', 'simple-blog-card' ) }
					max = { 300 }
					min = { 10 }
					value = { attributes.d_line_height }
					onChange = { ( value ) => setAttributes( { d_line_height: value } ) }
				/>
				<ToggleControl
					__nextHasNoMarginBottom
					label = { __( 'Open in new tab', 'simple-blog-card' ) }
					checked = { attributes.target_blank }
					onChange = { ( value ) => setAttributes( { target_blank: value } ) }
				/>
				<SelectControl
					label = { __( 'Character encoding', 'simple-blog-card' ) }
					value = { attributes.encoding }
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
					onChange={  ( value ) => setAttributes( { encoding: value } ) }
					__nextHasNoMarginBottom
				/>
			</InspectorControls>
		</div>
	);
}
