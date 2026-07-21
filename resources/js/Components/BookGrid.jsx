import BookCard from './BookCard';

export default function BookGrid({ books, savedBookIds = [], loanedBookIds = [] }) {
    return (
        <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            {books && books.map(book => (
                <BookCard
                    key={book.id}
                    book={book}
                    isSaved={savedBookIds.includes(book.id)}
                    hasActiveLoan={loanedBookIds.includes(book.id)}
                />
            ))}
        </div>
    );
}
