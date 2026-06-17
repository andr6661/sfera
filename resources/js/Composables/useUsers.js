import { useLocalStorage } from './useLocalStorage'

// Хук для работы с пользователями
export function useUsers() {
  const { get, set } = useLocalStorage()
  
  // Получить всех пользователей
  const getUsers = () => {
    return get('users', [])
  }
  
  // Сохранить пользователя
  const saveUser = (user) => {
    const users = getUsers()
    const newUser = {
      id: Date.now(),
      name: user.name,
      email: user.email,
      password: user.password,
      createdAt: new Date().toISOString()
    }
    users.push(newUser)
    set('users', users)
    return newUser
  }
  
  // Проверить существует ли email
  const emailExists = (email) => {
    const users = getUsers()
    return users.some(u => u.email === email)
  }
  
  // Удалить пользователя
  const deleteUser = (id) => {
    const users = getUsers()
    const filtered = users.filter(u => u.id !== id)
    set('users', filtered)
  }
  
  return { getUsers, saveUser, emailExists, deleteUser }
}