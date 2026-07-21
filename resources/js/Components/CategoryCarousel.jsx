import BookCard from './BookCard';
import {
    Carousel,
    CarouselContent,
    CarouselItem,
    CarouselPrevious,
    CarouselNext,
} from '@/Components/ui/carousel.jsx';

export default function CategoryCarousel({ books, savedBookIds = [], loanedBookIds = [] }) {
    if (!books || books.length === 0) return null;

    return (
        <Carousel
            opts={{ align: 'start', loop: false }}
            className="relative px-12 sm:px-14 -m-2 p-2 overflow-visible"
        >
            <CarouselContent className="overflow-visible">
                {books.map(book => (
                    <CarouselItem
                        key={book.id}
                        className="basis-full sm:basis-1/2 lg:basis-1/4 overflow-visible"
                    >
                        <div className="py-2 px-1 h-full overflow-visible">
                            <BookCard
                                book={book}
                                isSaved={savedBookIds.includes(book.id)}
                                hasActiveLoan={loanedBookIds.includes(book.id)}
                            />
                        </div>
                    </CarouselItem>
                ))}
            </CarouselContent>

            <CarouselPrevious className="hidden sm:flex" />
            <CarouselNext className="hidden sm:flex" />
        </Carousel>
    );
}
