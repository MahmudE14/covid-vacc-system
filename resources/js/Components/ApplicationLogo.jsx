export default function ApplicationLogo(props) {
    return (
        <svg
            {...props}
            className="h-[48px] w-[48px] text-gray-800 dark:text-white"
            width={24}
            height={24}
            fill="none"
            viewBox="0 0 24 24"
        >
            <path
                stroke="currentColor"
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth={2}
                d="M12 20a16.405 16.405 0 0 1-5.092-5.804A16.694 16.694 0 0 1 5 6.666L12 4l7 2.667a16.695 16.695 0 0 1-1.908 7.529A16.406 16.406 0 0 1 12 20Z" />
        </svg>
    );
}
