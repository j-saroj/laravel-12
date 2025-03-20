import { defineStore } from 'pinia';
import axios from 'axios';
import { useToast } from 'vue-toastification';
import { debounce } from 'lodash';
import { reactive, ref } from 'vue'; // Use reactive for arrays and objects

const toast = useToast();

export const useBlogStore = defineStore('blog', () => {
    // State is now reactive using Vue's composition API
    const blogs = reactive([]); // Store all blogs
    const filteredBlogs = reactive([]); // Filtered blogs based on search query
    const searchQuery = ref(''); // Search query string

    // Fetch all blogs from the backend
    const fetchBlogs = async () => {
        try {
            const response = await axios.get('/admin/blogs/all');
            blogs.length = 0; // Clear the previous blogs data
            blogs.push(...response.data.blogs); // Populate the blogs with the fetched data
            filteredBlogs.length = 0; // Clear previous filtered blogs
            filteredBlogs.push(...response.data.blogs); // Initialize filtered blogs
        } catch (error) {
            console.error('Error fetching blogs', error);
            toast.error('Failed to fetch blogs');
        }
    };

    // Create a new blog
    const createBlog = async (newBlog) => {
        try {
            await axios.post('/admin/blogs', newBlog, {
                headers: {
                    'Content-Type': 'application/json',
                },
            });

            toast.success('Blog created successfully!');
            await fetchBlogs(); // Refresh blog list after creating a new blog
        } catch (error) {
            console.error('Error creating blog', error);
            toast.error('Failed to create blog');
        }
    };

    // Delete a blog
    const deleteBlog = async (blogId) => {
        try {
            await axios.delete(`/admin/blogs/${blogId}`);
            toast.success('Blog deleted successfully!');
            await fetchBlogs(); // Refresh the blog list after deleting one
        } catch (error) {
            console.error('Error deleting blog', error);
            toast.error('Failed to delete blog');
        }
    };

    // Debounced search method
    const searchBlogs = debounce(() => {
        if (searchQuery.value.trim()) {
            filteredBlogs.length = 0; // Clear the previous filtered blogs
            filteredBlogs.push(
                ...blogs.filter((blog) =>
                    blog.title.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                    blog.content.toLowerCase().includes(searchQuery.value.toLowerCase())
                )
            );
        } else {
            filteredBlogs.length = 0; // Clear filtered blogs if query is empty
            filteredBlogs.push(...blogs); // Show all blogs when no search query is provided
        }
    }, 300); // 300ms debounce delay for search

    // Return the state and actions to be used in the components
    return {
        blogs,
        filteredBlogs,
        searchQuery,
        fetchBlogs,
        createBlog,
        deleteBlog,
        searchBlogs,
    };
});
