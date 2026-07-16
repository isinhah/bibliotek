import * as React from "react"
import { Button as ButtonPrimitive } from "@base-ui/react/button"
import { cva } from "class-variance-authority"
import { cn } from "@/lib/utils"

const buttonVariants = cva(
    "group/button inline-flex shrink-0 items-center justify-center rounded-none border-2 border-border-hard font-mono text-xs font-bold uppercase select-none outline-none active:translate-x-0.5 active:translate-y-0.5 active:shadow-none transition-all disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*='size-'])]:size-4",
    {
        variants: {
            variant: {
                primary:
                    "bg-primary text-primary-foreground hover:bg-primary/90 shadow-hard focus-visible:ring-2 focus-visible:ring-border-hard",

                secondary:
                    "bg-secondary text-secondary-foreground hover:bg-secondary/80 shadow-hard focus-visible:ring-2 focus-visible:ring-primary",

                danger:
                    "bg-danger text-danger-foreground hover:bg-danger/90 shadow-hard focus-visible:ring-2 focus-visible:ring-border-hard",

                warning:
                    "bg-warning text-warning-foreground hover:bg-warning/90 shadow-hard focus-visible:ring-2 focus-visible:ring-border-hard",

                oak:
                    "bg-oak text-primary-foreground hover:bg-oak/90 shadow-hard focus-visible:ring-2 focus-visible:ring-border-hard",

                outline:
                    "border-2 border-border-hard bg-panel-alt text-text-primary hover:bg-primary hover:text-primary-foreground shadow-hard",

                ghost:
                    "border-transparent bg-transparent text-text-primary hover:bg-panel shadow-none",
            },
            size: {
                default: "h-10 px-5 gap-2",
                sm: "h-8 px-3 text-[10px] gap-1.5",
                lg: "h-12 px-8 text-sm gap-2.5",
                icon: "size-10",
            },
        },
        defaultVariants: {
            variant: "primary",
            size: "default",
        },
    }
)

const Button = React.forwardRef(({ className, variant, size, ...props }, ref) => {
    return (
        <ButtonPrimitive
            ref={ref}
            className={cn(buttonVariants({ variant, size, className }))}
            {...props}
        />
    )
})
Button.displayName = "Button"

export { Button, buttonVariants }
