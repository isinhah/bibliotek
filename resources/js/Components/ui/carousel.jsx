"use client"

import * as React from "react"
import useEmblaCarousel from "embla-carousel-react"
import { ArrowLeft, ArrowRight } from "lucide-react"

import { cn } from "@/lib/utils"

const CarouselContext = React.createContext(null)

function useCarousel() {
    const context = React.useContext(CarouselContext)
    if (!context) {
        throw new Error("useCarousel deve ser usado dentro de um <Carousel />")
    }
    return context
}

function Carousel({
                      orientation = "horizontal",
                      opts,
                      setApi,
                      plugins,
                      className,
                      children,
                      ...props
                  }) {
    const [carouselRef, api] = useEmblaCarousel(
        {
            ...opts,
            axis: orientation === "horizontal" ? "x" : "y",
            dragFree: false,
            containScroll: "trimSnaps",
        },
        plugins
    )
    const [canScrollPrev, setCanScrollPrev] = React.useState(false)
    const [canScrollNext, setCanScrollNext] = React.useState(false)

    const onSelect = React.useCallback((api) => {
        if (!api) return
        setCanScrollPrev(api.canScrollPrev())
        setCanScrollNext(api.canScrollNext())
    }, [])

    const scrollPrev = React.useCallback(() => {
        api?.scrollPrev()
    }, [api])

    const scrollNext = React.useCallback(() => {
        api?.scrollNext()
    }, [api])

    const handleKeyDown = React.useCallback(
        (event) => {
            if (event.key === "ArrowLeft") {
                event.preventDefault()
                scrollPrev()
            } else if (event.key === "ArrowRight") {
                event.preventDefault()
                scrollNext()
            }
        },
        [scrollPrev, scrollNext]
    )

    React.useEffect(() => {
        if (!api || !setApi) return
        setApi(api)
    }, [api, setApi])

    React.useEffect(() => {
        if (!api) return
        onSelect(api)
        api.on("reInit", onSelect)
        api.on("select", onSelect)

        return () => {
            api?.off("select", onSelect)
        }
    }, [api, onSelect])

    return (
        <CarouselContext.Provider
            value={{
                carouselRef,
                api,
                opts,
                orientation:
                    orientation || (opts?.axis === "y" ? "vertical" : "horizontal"),
                scrollPrev,
                scrollNext,
                canScrollPrev,
                canScrollNext,
            }}
        >
            <div
                onKeyDownCapture={handleKeyDown}
                className={cn("relative", className)}
                role="region"
                aria-roledescription="carousel"
                data-slot="carousel"
                {...props}
            >
                {children}
            </div>
        </CarouselContext.Provider>
    )
}

function CarouselContent({ className, ...props }) {
    const { carouselRef, orientation } = useCarousel()

    return (
        <div
            ref={carouselRef}
            className="overflow-hidden"
            data-slot="carousel-content"
        >
            <div
                className={cn(
                    "flex",
                    orientation === "horizontal" ? "-ml-4" : "-mt-4 flex-col",
                    className
                )}
                {...props}
            />
        </div>
    )
}

function CarouselItem({ className, ...props }) {
    const { orientation } = useCarousel()

    return (
        <div
            role="group"
            aria-roledescription="slide"
            data-slot="carousel-item"
            className={cn(
                "min-w-0 shrink-0 grow-0 basis-full",
                orientation === "horizontal" ? "pl-4" : "pt-4",
                className
            )}
            {...props}
        />
    )
}

function CarouselPrevious({ className, ...props }) {
    const { orientation, scrollPrev, canScrollPrev } = useCarousel()

    return (
        <button
            type="button"
            data-slot="carousel-previous"
            aria-label="Livro anterior"
            disabled={!canScrollPrev}
            onClick={scrollPrev}
            className={cn(
                "absolute z-40 flex size-10 items-center justify-center",
                "rounded-none border-2 border-border-hard bg-panel text-text-primary",
                "shadow-hard transition-all duration-150",
                "hover:bg-primary hover:text-primary-foreground hover:shadow-[0_0_16px_rgba(225,29,72,0.55)]",
                "active:translate-x-0.5 active:translate-y-0.5 active:shadow-none",
                "disabled:opacity-30 disabled:pointer-events-none disabled:hover:bg-panel",
                orientation === "horizontal"
                    ? "top-1/2 left-2 -translate-y-1/2"
                    : "-top-3 left-1/2 -translate-x-1/2 rotate-90",
                className
            )}
            {...props}
        >
            <ArrowLeft className="size-5" strokeWidth={2.5} />
            <span className="sr-only">Anterior</span>
        </button>
    )
}

function CarouselNext({ className, ...props }) {
    const { orientation, scrollNext, canScrollNext } = useCarousel()

    return (
        <button
            type="button"
            data-slot="carousel-next"
            aria-label="Próximo livro"
            disabled={!canScrollNext}
            onClick={scrollNext}
            className={cn(
                "absolute z-40 flex size-10 items-center justify-center",
                "rounded-none border-2 border-border-hard bg-panel text-text-primary",
                "shadow-hard transition-all duration-150",
                "hover:bg-primary hover:text-primary-foreground hover:shadow-[0_0_16px_rgba(225,29,72,0.55)]",
                "active:translate-x-0.5 active:translate-y-0.5 active:shadow-none",
                "disabled:opacity-30 disabled:pointer-events-none disabled:hover:bg-panel",
                orientation === "horizontal"
                    ? "top-1/2 right-2 -translate-y-1/2"
                    : "-bottom-3 left-1/2 -translate-x-1/2 rotate-90",
                className
            )}
            {...props}
        >
            <ArrowRight className="size-5" strokeWidth={2.5} />
            <span className="sr-only">Próximo</span>
        </button>
    )
}

export {
    Carousel,
    CarouselContent,
    CarouselItem,
    CarouselPrevious,
    CarouselNext,
    useCarousel,
}
