(function(wp) {

	const { __ } = wp.i18n;
	const { registerBlockType, Editable, AlignmentToolbar, BlockControls, Toolbar } = wp.blocks;
	const { RichText, InspectorControls } = wp.blockEditor;
	const { Button, PanelBody, PanelRow, SelectControl } = wp.components;
	const { withAPIData, Component, Fragment, RawHTML } = wp.element;

	class selectPost extends Component {
		static getInitialState() {
			return {
				posts: [],
				post: {},
				selectedPost: 0,
				selectedPostTitle: '',
				alignment: 'align-left',
			};
		}

		constructor() {
			// The super keyword is used to access and call functions on an object's parent.
			super(...arguments);
			//console.log(this.props);
			this.state = this.constructor.getInitialState();
			this.getOptions = this.getOptions.bind(this);
			this.onChangeSelectPost = this.onChangeSelectPost.bind(this);
			this.onChangeAlignment = this.onChangeAlignment.bind(this);
		}

		getOptions_DEPRECATED() {
			return (
				//new wp.api.collections.Posts()).fetch()
				//.then((posts) => {
				wp.apiFetch({
					path: '/wp/v2/posts'
				}).then((posts) => {
					if (posts && 0 !== this.state.selectedPost) {
						const post = posts.find((item) => {
							return item.id == this.state.selectedPost;
						});
						this.setState({
							post,
							posts,
						});
					} else {
						this.setState({
							posts,
						});
					}
				})
			);
		}

		getOptions() {
			return (
				wp.apiFetch({
					path: '/wp-bd/v1/multiple-post-types?&type[]=post&type[]=page&per_page=-1'
				}).then((posts) => {
					if (posts && 0 !== this.state.selectedPost) {
						const post = posts.find((item) => {
							return item.id == this.state.selectedPost;
						});
						this.setState({
							post,
							posts,
						});
					} else {
						this.setState({
							posts,
						});
					}
				})
			);
		}


		componentDidMount() {
			this.setState({
				selectedPost: this.props.attributes.selectedPost,
				selectedPostTitle: this.props.attributes.selectedPostTitle,
				alignment: this.props.attributes.alignment,
			});

			this.getOptions();
		}

		onChangeSelectPost(value) {
			const post = this.state.posts.find((item) => {
				return item.id == parseInt(value);
			});

			this.props.setAttributes({
				selectedPost: parseInt(value),
				selectedPostTitle: post.title.rendered,
			});

			this.setState({
				selectedPost: parseInt(value),
				selectedPostTitle: post.title.rendered,
			});
		}

		onChangeAlignment(value) {
			this.props.setAttributes({
				alignment: value,
			});
			this.setState({
				alignment: value,
			});
		};

		render() {

			let output = 'Ladataan artikkeleita...';
			let selectedPost = {};
			let postOptions= [{
				value: '',
				label: 'Valitse artikkeli'
			}];

			let selectedAlignment = {};
			let alignmentOptions = [{
					value: 0,
					label: 'Valitse asemointi',
				},
				{
					value: 'align-left',
					label: 'Vasen',
				},
				{
					value: 'align-right',
					label: 'Oikea',
				}
			];

			if (this.state.posts.length > 0) {
				output = 'Löytyi ' + this.state.posts.length + ' artikkelia';
				this.state.posts.forEach((post) => {
					postOptions.push({
						value: post.id,
						label: post.title.rendered
					});
				});
			}

			if (this.state.selectedPost !== 0) {
				output = 'Muokkaa nostoartikkelia lohkon asetuksista';
			}


			return (
				<Fragment>
					<InspectorControls key="inspector">
						<PanelBody>
							<PanelRow>
								<SelectControl
									onChange={this.onChangeAlignment}
									value={this.props.attributes.alignment}
									label="Asemointi"
									options={alignmentOptions}
								/>
							</PanelRow>
							<PanelRow>
								<SelectControl
									onChange={this.onChangeSelectPost}
									value={this.props.attributes.selectedPost}
									label="Artikkeli"
									options={postOptions}
								/>
							</PanelRow>
						</PanelBody>
					</InspectorControls>
					<div className={`wp-block-promo ${this.props.attributes.alignment}`}>
						<div className="article">
							<div>
								<RichText
									tagName="h3"
									className="h4"
									placeholder="Nostoartikkelia ei valittuna"
									keepPlaceholderOnFocus={true}
									value={this.props.attributes.selectedPostTitle}
								/>
								<p className="read-more">({output})</p>
							</div>
						</div>
					</div>
				</Fragment>
			);
		}
	}

	//

	registerBlockType('betta/promo', {
		title: 'Artikkelinosto',

		category: 'common',

		supports: {
			multiple: true,
		},

		attributes: {
			alignment: {
				type: 'string',
				default: '',
			},
			selectedPost: {
				type: 'number',
				default: 0,
			},
			selectedPostTitle: {
				type: 'string',
				default: '',
			},
		},

		edit: selectPost,

		save: () => {
			return null;
		},
	});

}(window.wp));
