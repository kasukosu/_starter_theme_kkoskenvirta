(function(wp) {

	const { __ } = wp.i18n;
	const { registerBlockType, Editable, BlockControls, Toolbar } = wp.blocks;
	const { RichText, InspectorControls } = wp.blockEditor;
	const { Button, PanelBody, PanelRow, SelectControl } = wp.components;
	const { withAPIData, Component, Fragment, RawHTML } = wp.element;

	class selectContent extends Component {
		static getInitialState() {
			return {
				question: '',
				answer: '',
			};
		}

		constructor() {
			// The super keyword is used to access and call functions on an object's parent.
			super(...arguments);
			//console.log(this.props);
			this.state = this.constructor.getInitialState();
			this.onChangeQuestion = this.onChangeQuestion.bind(this);
			this.onChangeAnswer = this.onChangeAnswer.bind(this);

		}

		componentDidMount() {
			this.setState({
				question: this.props.attributes.question,
				answer: this.props.attributes.answer,
			});

		}

		onChangeQuestion(value) {

			this.props.setAttributes({
				question: value,
			});
			this.setState({
				question: value,
			});

		}
		onChangeAnswer(value) {


			this.props.setAttributes({
				answer: value,
			});

			this.setState({
				answer: value,
			});
		}



		render() {
			let question = '';
			let answer = '';

			return (

				<Fragment>

					<div className={`wp-block-toggle-content`}>
						<article>
							<RichText
								tagName="h3"
								className="question"
								placeholder="Kysymys"
								keepPlaceholderOnFocus={true}
								value={this.props.attributes.question}
								key="editable"
								onChange={this.onChangeQuestion}

							/>
							<RichText
								tagName="h4"
								placeholder="Vastaus"
								keepPlaceholderOnFocus={true}
								value={this.props.attributes.answer}
								key="editable"
								onChange={this.onChangeAnswer}

							/>
						</article>
					</div>
				</Fragment>
			);
		}
	}

	//

	registerBlockType('urhea/toggle-content', {
		title: 'UKK/FAQ',

		category: 'common',

		supports: {
			multiple: true,
		},

		attributes: {
			question: {
				type: 'string',
				default: '',
			},
			answer: {
				type: 'string',
				default: '',
			},
		},

		edit: selectContent,

		save: () => {
			return null;
		},
	});

}(window.wp));
