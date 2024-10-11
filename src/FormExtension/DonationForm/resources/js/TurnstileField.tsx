import type {TurnstileInstance} from '@marsidev/react-turnstile';
import {Turnstile} from '@marsidev/react-turnstile';
import {__} from '@wordpress/i18n';
import {useCallback, useEffect, useRef} from 'react';
import {GiveWP, TurnstileFieldSettings} from './types';

declare const window: GiveWP & TurnstileFieldSettings & Window;

/**
 * Check if the error is a required field error.
 * @since 1.0.0
 */
const isRequiredError = (error: {message: string, type: string}) => error.message === 'This is a required field' || error.type === 'string.empty';

/**
 * Error codes that should trigger a retry of the Turnstile challenge.
 * @since 1.0.0
 */
const errorCodeRetry = {
    /**
     * 11060*: Challenge timed out: The visitor took too long to solve the challenge and the challenge timed out.
     * 11062*: Challenge timed out: This error is for visible mode only. The visitor took too long to solve the interactive challenge and the challenge became outdated.
     */
    challengeTimeout: ['11060', '11062']
};

/**
 * @since 1.0.0
 */
export default function TurnstileField({
                                           ErrorMessage,
                                           fieldError,
                                           inputProps
                                       }) {
    const ref = useRef<TurnstileInstance | null>(null);
    const { setValue, setError } = window.givewp.form.hooks.useFormContext();
    const { submitCount, errors, isSubmitSuccessful } = window.givewp.form.hooks.useFormState();
    const fieldName = inputProps.name;
    const setFormError = useCallback(() =>
        setError('FORM_ERROR', {
            message: __('You must be a human.', 'give')
        }), [setError]
    );

    useEffect(() => {
        if (fieldError && errors && fieldName in errors && isRequiredError(errors[fieldName])) {
            setFormError();
        }
    }, [fieldError]);

    useEffect(() => {
        if (!isSubmitSuccessful) {
            ref.current?.reset();
        }
    }, [submitCount, isSubmitSuccessful]);

    return (
        <>
            <label className={fieldError && 'givewp-field-error-label'}>

                <Turnstile
                    ref={ref}
                    siteKey={window.giveTurnstileFieldSettings.siteKey}
                    onError={(errorCode: string) => {
                        console.error({ turnstileError: errorCode });

                        if (errorCodeRetry.challengeTimeout.some(code => errorCode.startsWith(code))) {
                            console.info('Retrying Turnstile challenge');
                            ref.current?.reset();
                        } else {
                            setFormError();
                        }
                    }}
                    onExpire={() => ref.current?.reset()}
                    onSuccess={(value: string) => {
                        setValue(fieldName, value);
                    }}
                />

                <input type="hidden" {...inputProps} />

                <ErrorMessage />
            </label>
        </>
    );
}
