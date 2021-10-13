(function(wp) {

	var registerPlugin = wp.plugins.registerPlugin;
	var PluginSidebar = wp.editPost.PluginSidebar;
	var PluginSidebarMoreMenuItem = wp.editPost.PluginSidebarMoreMenuItem;

	var el = wp.element.createElement;
	var Button = wp.components.Button;
	var TextareaControl = wp.components.TextareaControl;
	var SelectControl = wp.components.SelectControl;
	var MediaUpload = wp.blockEditor.MediaUpload;
	var withSelect = wp.data.withSelect;
	var withDispatch = wp.data.withDispatch;
	var compose = wp.compose.compose;

	var Fragment = wp.element.Fragment;

	// text

	var MetaBlockFieldText = compose(
		withDispatch(function(dispatch, props) {
			return {
				setMetaFieldValue: function(value) {
					dispatch('core/editor').editPost({
						meta: {
							[props.fieldKey]: value
						}
					});
				}
			}
		}),
		withSelect(function(select, props) {
			return {
				metaFieldValue: select('core/editor').getEditedPostAttribute('meta')[props.fieldKey],
				postType: select('core/editor').getCurrentPostType(),
			}
		})
	)(function(props) {
		if (props.postType == 'promo') {
			return null;
		}
		return (
			el(Fragment,
				{},
				el(TextareaControl, {
					label: props.fieldLabel,
					value: props.metaFieldValue,
					onChange: function(content) {
						props.setMetaFieldValue(content);
					},
				}),
			)
		);
	});

	// image

	var MetaBlockFieldImage = compose(
		withDispatch(function(dispatch, props) {
			return {
				setMetaFieldValue: function(value) {
					dispatch('core/editor').editPost({
						meta: {
							[props.fieldKey]: value
						}
					});
				}
			}
		}),
		withSelect(function(select, props) {
			return {
				metaFieldValue: select('core/editor').getEditedPostAttribute('meta')[props.fieldKey],
				postType: select('core/editor').getCurrentPostType(),
			}
		})
	)(function(props) {
		if (!['post', 'page'].includes(props.postType)) {
			return null;
		}
		return (
			el(Fragment,
				{},
				el('div',
					{},
					el('div',
						{
							className: 'components-responsive-wrapper',
						},
						el('div', {}, 'Kuvaikoni'),
						el('img',
							{
								src: props.metaFieldValue
							},
							null
						),
					),
					/*
					el(MediaUpload,
						{
							value: props.metaFieldValue,
							onSelect: function(media) {
								props.setMetaFieldValue(media.url);
							},
							render: function(renderProps) {
								return (
									el(Button,
										{
											className: 'components-button is-button is-default',
											onClick: renderProps.open
										},
										'Valitse kuva'
									)
								)
							}
						}
					)
					*/
				)
			)
		);
	});

	// post select

	var PostsDropdownControl = compose(
		withDispatch(function(dispatch, props) {
			return {
				setMetaFieldValue: function(value) {
					dispatch('core/editor').editPost({
						meta: {
							[props.fieldKey]: value
						}
					});
				}
			}
		}),
		withSelect(function(select, props) {
			let arr1 = select('core').getEntityRecords('postType', 'post', { per_page: -1 }) || [];
			let arr2 = select('core').getEntityRecords('postType', 'page', { per_page: -1 }) || [];
			let arr3 = [...arr1, ...arr2];
			return {
				posts: arr3,
				metaFieldValue: select('core/editor').getEditedPostAttribute('meta')[props.fieldKey],
				postType: select('core/editor').getCurrentPostType(),
			}
		})
	)(function(props) {
		if (!['post', 'page'].includes(props.postType)) {
			return null;
		}
		var options = [];

		if (props.posts) {
			options.push({
				value: 0,
				label: 'Valitse...'
			});
			props.posts.forEach((post) => {
				options.push({
					value: post.id,
					label: post.title.rendered
				});
			});
		} else {
			options.push({
				value: 0,
				label: 'Ladataan...'
			});
		}

		return (
			el(SelectControl,
				{
					label: props.fieldLabel,
					options : options,
					onChange: function(content) {
						props.setMetaFieldValue(content);
					},
					value: props.metaFieldValue,
				}
			)
		);
	});

	// person select

	var PeopleDropdownControl = compose(
		withDispatch(function(dispatch, props) {
			return {
				setMetaFieldValue: function(value) {
					dispatch('core/editor').editPost({
						meta: {
							[props.fieldKey]: value
						}
					});
				}
			}
		}),
		withSelect(function(select, props) {
			let arr = select('core').getEntityRecords('postType', 'person') || [];
			return {
				posts: arr,
				metaFieldValue: select('core/editor').getEditedPostAttribute('meta')[props.fieldKey],
				postType: select('core/editor').getCurrentPostType(),
			}
		})
	)(function(props) {
		if (!['post', 'page'].includes(props.postType)) {
			return null;
		}
		var options = [];

		if (props.posts) {
			options.push({
				value: 0,
				label: 'Valitse...'
			});
			props.posts.forEach((post) => {
				options.push({
					value: post.id,
					label: post.title.rendered
				});
			});
		} else {
			options.push({
				value: 0,
				label: 'Ladataan...'
			});
		}

		return (
			el(SelectControl,
				{
					label: props.fieldLabel,
					options : options,
					onChange: function(content) {
						props.setMetaFieldValue(content);
					},
					value: props.metaFieldValue,
				}
			)
		);
	});

	//

	registerPlugin('poistoa-sidebar', {
		render: () => {
			return (
				el(Fragment, {},
					el(PluginSidebarMoreMenuItem,
						{
							target: 'poistoa-sidebar',
							icon: 'star-filled',
						},
						'Lisätiedot'
					),
					el(PluginSidebar,
						{
							name: 'poistoa-sidebar',
							icon: 'star-filled',
							title: 'Lisätiedot',
						},
						/*
						el('div',
							{ className: 'poistoa-sidebar-content' },
							el(MetaBlockFieldText,
								{
									fieldLabel: 'Navigaation kuvausteksti',
									fieldKey: 'meta_navigation_description',
								}
							),
							el(MetaBlockFieldImage,
								{
									fieldLabel: 'Navigaation ikoni',
									fieldKey: 'meta_navigation_icon',
								}
							)
						),
						*/
						el('div',
							{ className: 'poistoa-sidebar-content' },
							el(PeopleDropdownControl,
								{
									fieldLabel: 'Avainhenkilö',
									fieldKey: 'meta_sidebar_contact_person',
								}
							),
							el(PostsDropdownControl,
								{
									fieldLabel: 'Aiheeseen liittyvä artikkeli/sivu',
									fieldKey: 'meta_sidebar_related_post',
								}
							)
						)
					),
				)
			);
		}
	});

})(
	window.wp
);
