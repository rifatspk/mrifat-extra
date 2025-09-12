import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl, ToggleControl, SelectControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

registerBlockType('mrifat-extra/contact-form', {
    edit: ({ attributes, setAttributes }) => {
        const { formTitle, showTitle, formAlignment } = attributes;

        const blockProps = useBlockProps({
            className: `mrifat-contact-form-wrapper alignment-${formAlignment}`
        });

        return (
            <>
                <InspectorControls>
                    <PanelBody title={__('Form Settings', 'mrifat-extra')}>
                        <ToggleControl
                            label={__('Show Title', 'mrifat-extra')}
                            checked={showTitle}
                            onChange={(value) => setAttributes({ showTitle: value })}
                        />

                        {showTitle && (
                            <TextControl
                                label={__('Form Title', 'mrifat-extra')}
                                value={formTitle}
                                onChange={(value) => setAttributes({ formTitle: value })}
                            />
                        )}

                        <SelectControl
                            label={__('Form Alignment', 'mrifat-extra')}
                            value={formAlignment}
                            options={[
                                { label: 'Left', value: 'left' },
                                { label: 'Center', value: 'center' },
                                { label: 'Right', value: 'right' }
                            ]}
                            onChange={(value) => setAttributes({ formAlignment: value })}
                        />
                    </PanelBody>
                </InspectorControls>

                <div {...blockProps}>
                    {showTitle && (
                        <h3 className="mrifat-form-title">{formTitle}</h3>
                    )}

                    <div className="mrifat-contact-form-preview">
                        <p><strong>Contact Form Preview</strong></p>
                        <p>The actual form will be displayed on the frontend.</p>
                        <div className="mrifat-form-preview-box">
                            <div className="mrifat-form-row">
                                <div className="mrifat-form-group">
                                    <label>Name *</label>
                                    <input type="text" placeholder="Your full name" disabled />
                                </div>
                                <div className="mrifat-form-group">
                                    <label>Email *</label>
                                    <input type="email" placeholder="your@email.com" disabled />
                                </div>
                            </div>
                            <div className="mrifat-form-group">
                                <label>Subject *</label>
                                <input type="text" placeholder="What's this about?" disabled />
                            </div>
                            <div className="mrifat-form-group">
                                <label>Message *</label>
                                <textarea rows="4" placeholder="Tell me about your project..." disabled></textarea>
                            </div>
                            <button className="mrifat-submit-button" disabled>Send Message</button>
                        </div>
                    </div>
                </div>
            </>
        );
    }
});