import {FC} from 'react';

/**
 * @since 1.0.0
 */
export type GiveWP = {
    givewp: {
        form: {
            hooks: {
                useWatch: (props: { name: string }) => any;
                useFormContext: () => any;
                useCurrencyFormatter: (currency: string) => Intl.NumberFormat;
                useDonationSummary: () => any;
                useFormState: () => any;
            }
            templates: {
                fields: {
                    [key: string]: FC<any>;
                };
                elements: {
                    [key: string]: FC<any>;
                };
            },
        },
    }
};

/**
 * @since 1.0.0
 */
export type TurnstileFieldSettings = {
    giveTurnstileFieldSettings: {
        siteKey: string;
    }
}
